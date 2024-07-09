<?php
namespace App\Http\Controllers;

use App\Calculator;
use App\Coupon;
use App\Customer;
use App\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ItemEvent;
use App\OptionPayment;
use App\OptionShipping;
use App\OrderDetailTemp;
use App\OrderHeader;
use App\OrderHeaderTemp;
use App\OrderRecipient;
use App\Repositories\Coupon\Contracts\CouponInterface;
use App\Repositories\Item\Contracts\ItemInterface;
use App\Repositories\Search\Contracts\SearchInterface;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Assets;
use URL;
use Auth;

use App\Store;
use App\CategoryDetail;
use App\Item;

use Cart as CartSession;
use App\Repositories\Cart\Contracts\CartInterface;
use JavaScript as Js;
use Illuminate\Support\Facades\Session;

class PublicPagesController extends Controller {
	/**
	 * @var SearchInterface
	 */
	private $searchInterface;
	/**
	 * @var Store
	 */
	private $store;
	/**
	 * @var Item
	 */
	private $item;
	/**
	 * @var CategoryDetail
	 */
	private $categoryDetail;
	/**
	 * @var ItemInterface
	 */
	private $itemInterface;
	/**
	 * @var OrderHeader
	 */
	private $orderHeader;
	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var Event
	 */
	private $event;

	private $coupon;
	/**
	 * @var ItemEvent
	 */
	private $itemEvent;

	/**
	 * @param SearchInterface $searchInterface
	 * @param ItemInterface $itemInterface
	 * @param Customer $customer
	 * @param Store $store
	 * @param Item $item
	 * @param CategoryDetail $categoryDetail
	 * @param OrderHeader $orderHeader
	 * @param Event $event
	 * @param Coupon $coupon
	 * @param ItemEvent $itemEvent
	 */
	public function __construct(SearchInterface $searchInterface,
								ItemInterface $itemInterface,
								Customer $customer,
								Store $store,
								Item $item,
								CategoryDetail $categoryDetail,
								OrderHeader $orderHeader,
								Event $event,
								Coupon $coupon,
								ItemEvent $itemEvent
	){


		$this->searchInterface = $searchInterface;
		$this->store = $store;
		$this->item = $item;
		$this->categoryDetail = $categoryDetail;
		$this->itemInterface = $itemInterface;
		$this->orderHeader = $orderHeader;
		$this->event = $event;
		$this->coupon = $coupon;

		if(Auth::customer()->check()){
			$this->customerId = Auth::customer()->get()->id;
		}
		$this->customer = $customer;
		$this->itemEvent = $itemEvent;
	}

	/**
	 * Home page
	 * @return \Illuminate\View\View
	 * @internal param Store $store
	 * @internal param Item $item
	 */
	public function home() {

		$items = $this->item->where('option_status_id',1)
		->whereHas('store',function($q){
			$q->where('option_status_id',1);
		})
		->active()
		->featured()
		->take(8)
		->orderBy('updated_at', 'desc')
		->get();

		$stores = $this->store->active()->get();

		return view('public.welcome', compact('stores', 'items'));
	}


	public function events() {

		$events = $this->event->whereStatus(1)->paginate(\Config::get('constants.paginationLimit'));

		return view('public.events', compact('events'));
	}

	/**
	 * @param Request $request
	 * @param Event $event
	 * @param ItemEvent $itemEvent
	 * @param $slug
	 * @return \Illuminate\View\View
	 */
	public function eventDetail(Request $request, ItemEvent $itemEvent, $slug) {

		$sortRequest = $request->all();

		$event = $this->event->whereSlug($slug)->first();

		if(! $event['status']){
			return redirect('/');
		}

		$eventId = $this->event->whereSlug($slug)->pluck('id');

		$itemEvent = $itemEvent->whereEventId($eventId)->paginate(\Config::get('constants.paginationLimit'));

		return view('public.eventDetail', compact('itemEvent', 'event', 'banner'));
	}

	/**
	 * Display home page of store
	 * @param Request $request
	 * @param $storeSlug
	 * @return Response
	 * @internal param string $slug
	 * @internal param SearchInterface $searchInterface
	 * @internal param Item $item
	 * @internal param Store $store
	 * @internal param Store $store
	 */
	public function store(Request $request, $storeSlug) {

		$sortRequest = $request->all();

		if(empty($sortRequest)){
			$sortRequest['sort'] = '';
		}

		$store = $this->store->whereSlug($storeSlug)->first();



		$title = $store['name'];

		$banner = $store->storeImage->first();


		$categoryDetailId = $this->categoryDetail->whereSlug($sortRequest['sort'])->pluck('id');



		/*Sort store items...*/
		if($store->option_status_id == 1)
		{
			if(! $categoryDetailId){

				$items = $this->item
					->whereHas('optionStatus', function($q) {
						$q->where('id', 1);
					})->whereHas('store', function ($q) use ($storeSlug) {
						$q->where('slug', $storeSlug);
					})
					->groupby('name');
				$items = $this->searchInterface->sortList($sortRequest, $items);
			}


			/*Filter store items...*/

			if($categoryDetailId){

				$items = $this->item
					->whereHas('optionStatus', function($q) {
						$q->where('id', 1);
					})->whereHas('itemCategory.categoryDetail', function ($q) use ($categoryDetailId) {
						$q->where('id', $categoryDetailId);
					})->whereHas('store', function ($q) use ($storeSlug) {
						$q->where('slug', $storeSlug);
					})->paginate(\Config('constants.itemsPerPage'))
					->groupby('name');

			}
		}
		else{
			return redirect('/');
		}

		return view('public.store', compact('items', 'title', 'banner', 'store', 'sortRequest'));
	}

	/**
	 * @param Request $request
	 * @param string $slug
	 * @return \Illuminate\View\View
	 * @internal param SearchInterface $searchInterface
	 * @internal param Item $item
	 * @internal param CategoryDetail $categoryDetail
	 */
	public function itemCategory(Request $request, $slug = '') {

		$sortRequest = $request->all();

		$categoryDetailId = $this->categoryDetail->whereSlug($slug)->pluck('id');
		$category = $this->categoryDetail->whereSlug($slug)->first();

		$title = $category['name'];

		$items = $this->item->whereHas('optionStatus', function($q){
			$q->where('id', 1);
		})
		->whereHas('store',function($q){
			$q->where('option_status_id',1);
		})
		->whereHas('ItemCategory', function ($q) use ($categoryDetailId) {
			$q->where('category_detail_id', $categoryDetailId);
		})
		->groupby('name');

		$items = $this->searchInterface->sortList($sortRequest, $items);


		return view('public.items', compact('items', 'title','sortRequest'));
	}

	/**
	 * Show item details i
	 * @param $itemSlug
	 * @param string $eventSlug
	 * @return Response
	 * @internal param Item $item
	 * @internal param ItemInterface $itemInterface
	 * @internal param $storeSlug
	 * @internal param string $slug
	 */
	public function itemDetail($itemSlug, $eventSlug = '') {

		$item = $this->item
			->whereSlug($itemSlug)->first();

		$itemEvent = '';

		/*Check if item is on event*/
		if($eventSlug){
			$event = $this->event->whereSlug($eventSlug)->first();

			if($event){
				$itemEvent = $this->itemEvent->whereEventId($event->id)->whereItemId($item->id)->first();
			}

		}

		Js::put(['id' => $item->id, 'itemEvent' => $itemEvent]);

		$variation = $this->itemInterface->getItemVariation($item->id);

		$relatedItems = $this->itemInterface->getItemsWithSameCategory($item->id);

		$category = '';

		//Quick fix for displaying size chart
		foreach($item->itemCategory as $cat){
			if($cat->category_detail_id == 4){
				$category = 'menShoes';
			}else if($cat->category_detail_id == 7){
				$category = 'womenShoes';
			}elseif($cat->category_detail_id == 10){
				$category = 'kidsShoes';
			}elseif($cat->category_detail_id == 5){
				$category = 'menClothes';
			}elseif($cat->category_detail_id == 8){
				$category = 'womenClothes';
			}
		}

		$currentRelatedItemCode = $item->related_item_code;

		Assets::add([
			URL::asset('js/cart/CartSrvc.js'),
			URL::asset('js/item/ItemSrvc.js'),
			URL::asset('js/item/ItemDetailCtrl.js'),
			URL::asset('js/wishlist/WishlistSrvc.js'),
			URL::asset('js/wishlist/WishlistCtrl.js'),
		]);

		return view('public.itemDetail', compact('item', 'itemEvent', 'relatedItems', 'variation', 'category', 'currentRelatedItemCode'));
	}

	public function cart(CartInterface $cartInterface, CouponInterface $couponInterface) {

		/*Initialize cart session*/
		Session::put('validCartSession', str_random(5));

//		$cart = $cartInterface->content();
		$subtotal = $cartInterface->getSubtotal();
		$grandTotal = $cartInterface->getGrandTotal();

		$discountType = $couponInterface->getDiscountType();
		$discount = $couponInterface->getDiscount();
		$appliedCoupon = $couponInterface->getAppliedCoupon();

		$storeIdWithCoupon = $couponInterface->getStoreWithDiscount();

		if($storeIdWithCoupon){
			$storeWithCoupon = $this->store->find($storeIdWithCoupon);
		}

		Js::put(['subtotal' => $subtotal]);

		Assets::add(['cart/CartCtrl.js', 'cart/CartSrvc.js', 'coupon/CouponSrvc.js']);

		return view('public.cart', compact('subtotal', 'grandTotal', 'discountType', 'discount', 'appliedCoupon', 'storeWithCoupon'));
	}

	public function checkout(CouponInterface $couponInterface, OptionPayment $optionPayment, OptionShipping $optionShipping, OrderHeaderTemp $orderHeaderTemp, OrderDetailTemp $orderDetailTemp, Calculator $calculator) {
		//echo "checkout";
		$paymentOptions = $optionPayment->all();

		$shippingOptions = $optionShipping->all();

		$customerId = Auth::customer()->get()->id;
		$orderHeaderId = $orderHeaderTemp->whereCustomerId($customerId)->orderBy('id', 'desc')->pluck('id');

		$orderDetails = $orderDetailTemp->whereOrderHeaderTempId($orderHeaderId)->get();


		$orderHeader = $orderHeaderTemp->whereCustomerId($customerId)->orderBy('id', 'desc')->first();


		$minimumSubtotal = 800; // Default minimum subtotal
		$shippingFee = $calculator->calculateShippingRate($orderHeader->subtotal, $minimumSubtotal);

		$discount = $couponInterface->getDiscount();

		$coupon = $couponInterface->getActivatedCoupon();

		$discountTypeId = $couponInterface->getDiscountTypeId();

		$grandTotal = $calculator->calculateOrderGrandTotal($orderHeader->subtotal, $shippingFee, $discount, $discountTypeId);

		Assets::add([
			URL::asset('js/checkout/CheckoutCtrl.js'),
			URL::asset('js/checkout/CheckoutSrvc.js'),
			URL::asset('js/payment/PaymentSrvc.js'),
			URL::asset('js/email/EmailSrvc.js'),
			URL::asset('js/order/OrderSrvc.js'),
			URL::asset('js/coupon/CouponSrvc.js')
		]);

		Js::put(['orderHeaderId' => $orderHeaderId]);
		Js::put(['grandTotal' => $grandTotal]);
		Js::put(['orderDetails' => $orderDetails]);
		Js::put(['shippingFee' => $shippingFee]);
		Js::put(['subtotal' => $orderHeader->subtotal]);


		return view('public.checkout', compact('paymentOptions', 'shippingOptions', 'orderDetails', 'orderHeader', 'shippingFee', 'grandTotal', 'discount', 'coupon'));
	}

	public function privacy() {
		return view('public.privacy');
	}

	public function about() {
		return view('public.about');
	}

	public function brand() {
		return view('public.brand');
	}

	public function success() {
		$this->deleteSessions();

		return view('public.success');
	}

	public function successPaypal() {
		$this->deleteSessions();
		return view('public.successPaypal');
	}

	public function successPaymentCenters() {
		$this->deleteSessions();
		return view('public.successPaymentCenters');
	}

	public function successCod() {
		$this->deleteSessions();
		return view('public.successCod');
	}

	/**
	 * @param Request $request
	 * @param OrderHeader $orderHeader
	 * @return \Illuminate\View\View
	 */
	public function successDragonpay(Request $request, OrderHeader $orderHeader) {

		$this->deleteSessions();

		$data = $request->all();

		$digestString = $data['txnid'] . ':' . $data['refno'] . ':' . $data['status'] . ':' . urldecode($data['message']) . ':' .env('DRAGONPAY_MERCHANT_PASSWORD');

		$digest = sha1($digestString);

		if($digest != $data['digest']){
			return view('public.successDragonpayFailed');
		}

		//Change order status to paid if success..
		if($data['status'] == 'S'){
//			$orderHeader->whereOrderNumber($data['txnid'])->update(['option_order_status_id' => \Config::get('constants.orderPaidStatus')]);
			$view = 'public.successDragonpayPaid';
		}

		if($data['status'] == 'P'){
			$view = 'public.successDragonpayPending';
		}

		return view($view);

	}


	public function deleteSessions() {
		Session::forget('validCheckoutSession');
		Session::forget('validCartSession');
	}

	public function faq() {
		return view('public.faq');
	}

	public function terms() {
		return view('public.terms');
	}

	public function contact() {
		return view('public.contact');
	}

	public function sizechart() {
		return view('public.sizechart');
	}

	/////////////////////
	//Customer Account //
	/////////////////////

	public function dashboard() {

//		return $this->customerOrderList();

//		return view('public.account.dashboard');
	}

	public function profile() {

		$customer = $this->customer->find($this->customerId);

		return view('public.account.profile', compact('customer'));
	}

	public function editProfile() {

		Js::put(['id' => $this->customerId]);

		Assets::add([URL::asset('js/customer/EditProfileCtrl.js'),URL::asset('js/customer/CustomerSrvc.js')]);

		return view('public.account.editProfile');
	}

	public function changePassword() {

		Assets::add([URL::asset('js/customer/ChangePasswordCtrl.js'),URL::asset('js/customer/CustomerSrvc.js')]);

		return view('public.account.changePassword');
	}

	public function wishlist() {

		return view('public.account.wishlist');
	}

	public function customerOrderList() {

		$orders = $this->orderHeader->whereCustomerId($this->customerId)->orderBy('created_at','desc')->paginate(\Config::get('constants.paginationLimit'));

		return view('public.account.orders.list', compact('orders'));
	}

	public function customerOrderShow(OrderRecipient $orderRecipient, $orderHeaderId) {

		$orderHeader = $this->orderHeader->find($orderHeaderId);

		$recipient = $orderRecipient->find($orderHeader->order_recipient_id);
		$customer = $this->customer->find($orderHeader->customer_id);

		return view('public.account.orders.show', compact('orderHeader', 'recipient', 'customer'));
	}


}
