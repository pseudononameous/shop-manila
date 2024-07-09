<?php namespace App\Http\Controllers;

use App\Calculator;
use App\Coupon;
use App\CouponCustomerUsage;
use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\ItemSize;
use App\OrderDetail;
use App\OrderDetailTemp;
use App\OrderHeader;
use App\OrderHeaderTemp;
use App\Item;
use App\CartDetail;
use App\CartHeader;
use App\Repositories\Cart\Contracts\CartInterface;
use App\Repositories\Coupon\Contracts\CouponInterface;
use App\Repositories\Order\Contracts\OrderInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use MongoDB\BSON\Javascript;

class SaveOrderController extends Controller {
	/**
	 * @var CartInterface
	 */
	private $cartInterface;
	/**
	 * @var Calculator
	 */
	private $calculator;
	/**
	 * @var OrderHeaderTemp
	 */
	private $orderHeaderTemp;
	/**
	 * @var OrderDetailTemp
	 */
	private $orderDetailTemp;

	/**
	 * @var OrderInterface
	 */
	private $orderInterface;
	/**
	 * @var Coupon
	 */
	private $coupon;
	/**
	 * @var CouponInterface
	 */
	private $couponInterface;
	/**
	 * @var CouponCustomerUsage
	 */
	private $couponCustomerUsage;
	/**
	 * @var Item
	 */
	private $item;
	/**
	 * @var ItemSize
	 */
	private $itemSize;
	/**
	 * @var OrderHeader
	 */
	private $orderHeader;
	/**
	 * @var OrderDetail
	 */
	private $orderDetail;
	/**
	 * @var CartDetail
	 */
	private $cartDetail;
	/**
	 * @var CartHeader
	 */
	private $cartHeader;


	/**
	 * @param CartInterface $cartInterface
	 * @param OrderDetail $orderDetail
	 * @param OrderHeader $orderHeader
	 * @param CouponInterface $couponInterface
	 * @param OrderInterface $orderInterface
	 * @param Item $item
	 * @param ItemSize $itemSize
	 * @param Coupon $coupon
	 * @param CouponCustomerUsage $couponCustomerUsage
	 * @param Calculator $calculator
	 * @param OrderHeaderTemp $orderHeaderTemp
	 * @param OrderDetailTemp $orderDetailTemp
	 */
	public function __construct(CartInterface $cartInterface, OrderDetail $orderDetail ,OrderHeader $orderHeader, CouponInterface $couponInterface, OrderInterface $orderInterface, Item $item, ItemSize $itemSize, Coupon $coupon, CouponCustomerUsage $couponCustomerUsage, Calculator $calculator, OrderHeaderTemp $orderHeaderTemp, OrderDetailTemp $orderDetailTemp, CartDetail $cartDetail, CartHeader $cartHeader) {


		$this->cartInterface = $cartInterface;
		$this->calculator = $calculator;
		$this->orderHeaderTemp = $orderHeaderTemp;
		$this->orderDetailTemp = $orderDetailTemp;
		$this->cartDetail = $cartDetail;
		$this->cartHeader = $cartHeader;

		$this->cart = Cart::instance('shopping');

		if (Auth::customer()->check()) {
			$this->cart = $cartInterface;
			$this->customerId = Auth::customer()->get()->id;
		}

		$this->orderInterface = $orderInterface;
		$this->coupon = $coupon;
		$this->couponInterface = $couponInterface;
		$this->couponCustomerUsage = $couponCustomerUsage;
		$this->item = $item;
		$this->itemSize = $itemSize;
		$this->orderHeader = $orderHeader;
		$this->orderDetail = $orderDetail;

		$this->emailController = App::make('App\Http\Controllers\EmailController');
	}

	public function saveTempOrder() {

		$cart = $this->cart->content();

		$discount = $this->couponInterface->getDiscount();

		$subtotal = $this->calculator->calculateCartItemsTotal($cart);

		$type = $this->couponInterface->getDiscountType();

		$grandTotal = $this->calculator->calculateCartGrandTotal($subtotal, $discount, $type);

		$orderHeaderTempId = $this->orderHeaderTemp->createHeader($this->customerId, $grandTotal, $subtotal, $discount);

		$this->orderDetailTemp->createDetails($orderHeaderTempId, $cart);

	}

	public function placeOrder(Request $request) {
		$data = $request->all();
		/*Initialize coupon variables*/
		$discount = $this->couponInterface->getDiscount();
		$type = $this->couponInterface->getDiscountType();
		$discountTypeId = $this->couponInterface->getDiscountTypeId();
//		$storeWithDiscount = $this->couponInterface->getStoreWithDiscount();

		//Create order recipients
		$or = $this->orderInterface->createOrderRecipient($data['recipient']);

		//Get order header temp
		$orderHeaderTemp = $this->orderHeaderTemp->whereCustomerId($this->customerId)->orderBy('id', 'desc')->first();


		$minimumSubtotal = $data['minimumSubtotal'];
		$shippingRate = $this->calculator->calculateShippingRate($orderHeaderTemp['subtotal'], $minimumSubtotal);

		$grandTotal = $this->calculator->calculateOrderGrandTotal($orderHeaderTemp['subtotal'], $shippingRate, $discount, $discountTypeId);

//		$paymentOptionId = $data['option_payment_id'];
//		$shippingOptionId = $data['option_shipping_id'];
//		$subtotal = $orderHeaderTemp['subtotal'];
//		$orderNumber = $orderHeaderTemp['order_number'];

		/*Set discount price depending on type*/
		$discountPrice = $discount;

		if ($type == 'Percentage') {
			$discountPrice = ($orderHeaderTemp['subtotal'] * $discount) / 100;
		}
		/*End*/

		// if(isset($data['minimum']) && $data['minimum'] == 500){
		// 	//$grandTotal = 500;
		// 	if($grandTotal <= 500){
		// 		$shippingRate = (500 - $orderHeaderTemp['subtotal']);
		// 	}else{
		// 		$grandTotal = $orderHeaderTemp['subtotal'];
		// 		$shippingRate = 0;
		// 	}
		// }

		/*Create placed order*/
		$oh = $this->orderInterface->createOrderHeader($or->id,
			$data['option_payment_id'],
			$data['option_shipping_id'],
			$orderHeaderTemp['order_number'],
			$grandTotal,
			$orderHeaderTemp['subtotal'],
			$discountPrice,
			$shippingRate);

		//Create order details
		$orderDetailTemp = $this->orderDetailTemp->whereOrderHeaderTempId($orderHeaderTemp['id'])->get();

		$this->orderInterface->createOrderDetails($oh->id, $orderDetailTemp);

		$this->saveUsedCoupon();

		$this->decrementStock($orderDetailTemp);

		$this->refreshCart();

//		$this->emailController->notifyAdminOfOrder($oh->id);

		//Create session for valid checkout
		Session::put('validCheckoutSession', str_random(5));
		return ['id' => $oh->id];

	}

	/**
	 * Remove cart from database or session. Remove coupon.
	 */
	public function refreshCart() {
		$this->couponInterface->disableCoupon();

		$this->cartInterface->destroy();

		return;
	}

	/**
	 * Decrease item stock
	 * @param $orderDetailTemp
	 */
	public function decrementStock($orderDetailTemp) {

		foreach ($orderDetailTemp as $od) {
			$itemId = $od['item_id'];

			$decrement = $od['qty'];

			//Decrement overall stock qty
			$i = $this->item->find($itemId);
			$i->qty > 0 ? $i->decrement('qty', $decrement):$i->decrement('qty', 0);
			//Decrement size qty
			if (isset($od['option_size_id'])) {

				$is = $this->itemSize->whereItemId($itemId)->whereOptionSizeId($od['option_size_id'])->first();
				$is->decrement('stock', $decrement);
			}

		}
	}

	/**
	 * Record a used coupon
	 */
	public function saveUsedCoupon() {
		$coupon = $this->couponInterface->getActivatedCoupon();

		if (!$coupon)
			return;

		/*Record total usage*/
		$c = $this->coupon->find($coupon['couponId']);

		$c->increment('total_usage');


		/*Record customer usage*/

		if ($c = $this->couponCustomerUsage->whereCouponId($coupon['couponId'])->whereCustomerId($this->customerId)->first()) {
			$c->increment('usage');
		} else {

			$data = [
				'customer_id' => $this->customerId,
				'coupon_id'   => $coupon['couponId'],
				'usage'       => 1,
			];

			$this->couponCustomerUsage->create($data);
		}

		return;

	}


	/**
	 * Verify Place Order items
	 * @param Request $request
	 * @return array|int
	 */
	public function verifyPlaceOrder(Request $request){
		$orderItems = $this->orderDetailTemp->whereOrderHeaderTempId($request->all())->get();
//		$cartHeaderId = $this->cartHeader->whereCustomerId($this->customerId)->pluck('id');
		$outOfStock = [];
		foreach($orderItems as $row){
			if($this->checkOrderItemSizeStock($row) == 0){
				$outOfStock[] = $this->item->whereId($row->item_id)->pluck('name'); // STORE OUT OF STOCK ITEM IN ARRAY
//				$this->deleteOrderItemsOutOfStock($cartHeaderId, $row->item_id, $row->option_size_id);
			}
		}
		return $outOfStock;
	}

	/** Check if Item in the order is available in the item size
	 * @param $row
	 * @return mixed
	 */
	public function checkOrderItemSizeStock($row){
		$stocks  = $this->itemSize->whereItemId($row->item_id)->whereOptionSizeId($row->option_size_id)->where('stock','>=',$row->qty)->count();
		return $stocks;
	}

	/** Delete the item in cart that are out of stock
	 * @param $cardHeaderId
	 * @param $itemId
	 * @param $itemSizeId
	 */
	public function deleteOrderItemsOutOfStock($cardHeaderId, $itemId, $itemSizeId){
		$id = $this->cartDetail->whereCartHeaderId($cardHeaderId)->whereItemId($itemId)->whereOptionSizeId($itemSizeId)->pluck('id');
		$this->cartDetail->destroy($id);
	}


}
