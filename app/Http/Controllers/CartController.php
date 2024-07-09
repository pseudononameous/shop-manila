<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OptionSize;
use App\Repositories\Coupon\Contracts\CouponInterface;
use App\Repositories\Item\Contracts\ItemInterface;
use App\Repositories\Item\ItemRepository;
use Illuminate\Http\Request;

use App\Repositories\Cart\Contracts\CartInterface;

use Auth;
use Cart as CartSession;
use App\Item;
use Illuminate\Support\Facades\Session;
use Input;
use App\Calculator;
use App\ItemSize;
use App\CartDetail;
use App\CartHeader;

class CartController extends Controller {

	protected $cart;
	protected $item;
	protected $calculator;
	/**
	 * @var CouponInterface
	 */
	private $couponInterface;
	/**
	 * @var OptionSize
	 */
	private $optionSize;
	/**
	 * @var ItemInterface
	 */
	private $itemInterface;
	/**
	 * @var itemSize
	 */
	private $itemSize;
	/**
	 * @var cartDetail
	 */
	private $cartDetail;
	/**
	 * @var cartHeader
	 */
	private $cartHeader;

	/**
	 * @param CartInterface $cartInterface
	 * @param CouponInterface $couponInterface
	 * @param Item $item
	 * @param OptionSize $optionSize
	 * @param Calculator $calculator
	 * @param ItemInterface $itemInterface
	 * @internal param ItemRepository $itemRepository
	 */
	public function __construct(CartInterface $cartInterface, CouponInterface $couponInterface, Item $item, OptionSize $optionSize, Calculator $calculator, ItemInterface $itemInterface, ItemSize $itemSize,
	                            CartDetail $cartDetail, CartHeader $cartHeader) {
		$this->cart = CartSession::instance('shopping');
		$this->item = $item;
		$this->calculator = $calculator;
		$this->itemSize = $itemSize;
		$this->cartDetail = $cartDetail;
		$this->cartHeader = $cartHeader;

		//Use database cart if customer is logged in
		if (Auth::customer()->check()) {
			$this->cart = $cartInterface;
		}
		$this->couponInterface = $couponInterface;
		$this->optionSize = $optionSize;
		$this->itemInterface = $itemInterface;
	}

	/**
	 * Get cart
	 * @return array
	 */
	public function getCart() {
		return $this->cart->content();
	}


	/**
	 * Get item using item id
	 * @param  int $itemId
	 * @param null $itemEvent
	 * @return array Data to be added in cart
	 */
	public function getItem($itemId, $itemEvent = null) {

		$item = $this->item->with('store')->find($itemId);

		$qty = (Input::get('qty') == '') ? 1 : Input::get('qty');

		$price = $this->itemInterface->getItemPrice($item, $itemEvent);

		$sizeId = Input::get('sizeId');

		$size = '';

		if ($sizeId) {
			$size = $this->optionSize->find($sizeId)->name;
		}


		$itemEventId = 0;
		if ($itemEvent) {
			$itemEventId = $itemEvent['id'];
		}

		$itemData = [
			'id'      => $itemId,
			'name'    => $item->name,
			'qty'     => $qty,
			'price'   => $price,
			'options' => [
				'shortDescription' => $item->short_description,
				'storeSlug'        => $item->store->slug,
				'itemSlug'         => $item->slug,
				'size'             => $size,
				'sizeId'           => $sizeId,
				'storeId'          => $item->store_id,
				'subtotal'         => $price * $qty,
				'itemEventId'          => $itemEventId,
			],

		];

		return $itemData;
	}

	/**
	 * Add item using itemId
	 * @param Request $request
	 * @param int $itemId
	 */
	public function add(Request $request, $itemId) {

		$data = $request->all();

		if (empty($data['itemEvent'])) {
			$data['itemEvent'] = '';
		}

		$item = $this->getItem($itemId, $data['itemEvent']);

		$this->cart->add($item);
	}

	/**
	 * Update items from shopping cart view
	 * @param Request $request
	 */
	public function multipleUpdate(Request $request) {

		$this->couponInterface->disableCoupon();

		$cart = $request->all();

		foreach ($cart as $value) {

			$rowId = (array_key_exists('rowid', $value)) ? $value['rowid'] : $value['id'];

			$subtotal = $this->calculator->calculateSubtotal($value['qty'], $value['price']);

			$data = [
				'qty'     => $value['qty'],
				'options' => [
					'subtotal' => $subtotal,
					'sizeId'   => $value['options']['sizeId'],
				],

			];

			$this->cart->update($rowId, $data);
		}

		return;
	}

	/**
	 * Remove item from cart
	 * @param  int /string $rowId
	 * @return void
	 */
	public function remove($rowId) {
		$this->cart->remove($rowId);
		Session::forget('coupon');
	}


}
