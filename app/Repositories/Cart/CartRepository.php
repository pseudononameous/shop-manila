<?php namespace App\Repositories\Cart;

use Auth;
use App\CartDetail;
use App\CartHeader;
use App\Item;
use App\Repositories\Cart\Contracts\CartInterface;
use Illuminate\Support\Facades\App;
use Cart as CartSession;

class CartRepository implements CartInterface {
	/**
	 * @var CartHeader
	 */
	private $cartHeader;
	/**
	 * @var CartDetail
	 */
	private $cartDetail;
	/**
	 * @var Item
	 */
	private $item;

	/**
	 * @internal param CartHeader $cartHeader
	 * @internal param CartDetail $cartDetail
	 * @internal param Item $item
	 */
	public function __construct() {

		$this->customerId = 0;

		if (Auth::customer()->check()) {
			$this->customerId = Auth::customer()->get()->id;
		}

		$this->cartHeader = App::make('App\CartHeader');
		$this->cartDetail = App::make('App\CartDetail');
		$this->item = App::make('App\Item');
		$this->calculator = App::make('App\Calculator');
		$this->couponInterface = App::make('App\Repositories\Coupon\Contracts\CouponInterface');
		$this->itemInterface = App::make('App\Repositories\Item\Contracts\ItemInterface');
		$this->optionSize = App::make('App\OptionSize');
		$this->itemEvent = App::make('App\ItemEvent');


		$this->cart = CartSession::instance('shopping');

		if (Auth::customer()->check()) {
			$this->cart = $this;
		}


		$this->cartHeaderId = $this->cartHeader->whereCustomerId($this->customerId)->orderBy('id', 'desc')->pluck('id');
	}

	public function content() {

		$cartDetail = $this->cartDetail->whereCartHeaderId($this->cartHeaderId)->get();

		$cart = [];

		foreach ($cartDetail as $value) {

//			print_r($value);
			$itemEvent = $this->itemEvent->whereId($value->item_event_id)->whereItemId($value->item_id)->first();

			$price = $this->itemInterface->getItemPrice($value->item, $itemEvent);

			$size = $this->optionSize->find($value->option_size_id);

			$cart[] = [
				'id'      => $value->item_id,
				'rowid'   => $value->id,
				'name'    => $value->item->name,
				'qty'     => $value->qty,
				'price'   => $price,
				'options' => [
					'shortDescription' => $value->item->short_description,
					'itemSlug'         => $value->item->slug,
					'size'             => (isset($size) ? $size->name : ''),
					'sizeId'           => (isset($value->option_size_id) ? $value->option_size_id : null),
					'storeId'          => (isset($value->item->store_id) ? $value->item->store_id : null),
					'subtotal'         => $this->calculator->calculateSubtotal($value->qty, $value->item->price),
					'itemEventId'          => $value->event_id,
				],

			];
		}

		return $cart;

	}


	public function add($item) {

		$cartHeaderId = $this->createHeader();

		$this->createDetail($cartHeaderId, $item);

	}

	public function update($rowId, $data) {

		$r = $this->cartDetail->find($rowId);
		$r->qty = $data['qty'];

		$r->save();

		return;

	}

	/**
	 * @return mixed
	 */
	public function createHeader() {

		$customerId = Auth::customer()->get()->id;
		$cartHeaderId = $this->cartHeader->whereCustomerId($customerId)->orderBy('id', 'desc')->pluck('id');

		if (!$cartHeaderId) {

			$d = [
				'customer_id' => $customerId,
			];

			$cart = $this->cartHeader->create($d);

			$cartHeaderId = $cart->id;
		}

		return $cartHeaderId;
	}

	/**
	 * @param $cartHeaderId
	 * @param $item
	 */
	public function createDetail($cartHeaderId, $item) {

		$optionSizeId = (isset($item['options']['sizeId'])) ? $item['options']['sizeId'] : null;
		$itemEventId = (isset($item['options']['itemEventId'])) ? $item['options']['itemEventId'] : null;


		$d = [
			'cart_header_id' => $cartHeaderId,
			'item_id'        => $item['id'],
			'qty'            => $item['qty'],
			'option_size_id' => $optionSizeId,
		];

		//Add item event id if item selected is from an event
		if($itemEventId){
			$d['item_event_id'] = $itemEventId;
		}

		//Get cart item that matches the item to be added
		$cartItem = $this->cartDetail
			->whereCartHeaderId($cartHeaderId)
			->whereItemId($item['id'])
			->whereOptionSizeId($optionSizeId)
			->itemHasEvent($itemEventId)
			->first();

		if (!$cartItem) {

			$this->cartDetail->create($d);

		} else {

			$r = $this->cartDetail->find($cartItem->id);

			$updatedQty = $r->qty + $d['qty'];

			$r->qty = $updatedQty;
			$r->option_size_id = $optionSizeId;

			$r->save();
		}

		return;

	}

	public function remove($rowId) {

		$r = $this->cartDetail->find($rowId);

		$r->delete();
	}


	/**
	 * Delete all cart contents
	 */
	public function destroy() {

		$cartHeaderId = $this->cartHeader->whereCustomerId($this->customerId)->pluck('id');

		$this->cartDetail->whereCartHeaderId($cartHeaderId)->delete();

	}

	/**
	 * Get cart subtotal
	 * @return mixed
	 */
	public function getSubtotal() {

		$cart = $this->cart->content();

		$subtotal = $this->calculator->calculateCartItemsTotal($cart);

		return $subtotal;
	}

	/**
	 * Get cart grand total
	 * Determine grand total depending on coupon applied..
	 * @return mixed
	 */
	public function getGrandTotal() {
		$cart = $this->cart->content();

		$subtotal = $this->calculator->calculateCartItemsTotal($cart);

		$discount = 0;
		$type = 0;
		$storeIdWithDiscount = null;

		if ($coupon = $this->couponInterface->getActivatedCoupon()) {
			$discount = $coupon['discount'];
			$type = $coupon['type'];
			$storeIdWithDiscount = $coupon['storeIdWithDiscount'];
		}

		//For coupon with all stores...
		if (!$storeIdWithDiscount) {

			$grandTotal = $this->calculator->calculateCartGrandTotal($subtotal, $discount, $type);
		} //For coupon with specified stores...
		else {
			$grandTotal = $this->calculator->calculateCartGrandTotalWithStoreCoupon($discount, $type, $storeIdWithDiscount, $cart);
		}


		return $grandTotal;

	}

	/**
	 * Used after customer login
	 */
	public function mergeCarts() {
		if (Auth::customer()->check()) {


			$cart = CartSession::instance('shopping')->content();

			foreach ($cart as $value) {

				$data = [
					'id'  => $value->id,
					'qty' => $value->qty,

				];

				$data['options'] = [
					'sizeId'      => $value->options->sizeId,
					'itemEventId' => $value->options->itemEventId,
				];

				$this->add($data);

			}

			CartSession::instance('shopping')->destroy();

		}
	}
}