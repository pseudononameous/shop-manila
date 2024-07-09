<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OrderDetail;
use App\OrderDetailStatus;
use App\OrderHeader;
use App\CouponCustomerUsage;
use App\Coupon;

use App\Repositories\Invoice\Contracts\InvoiceInterface;
use App\Repositories\Order\Contracts\OrderInterface;
use App\Repositories\Coupon\Contracts\CouponInterface;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;

use Assets;
use JavaScript as Js;

class AdminOrderDetailController extends Controller {
	/**
	 * @var OrderDetail
	 */
	private $orderDetail;
	/**
	 * @var OrderHeader
	 */
	private $orderHeader;
	/**
	 * @var CouponCustomerUsage
	 */
	private $couponCustomerUsage;
	/**
	 * @var InvoiceInterface
	 */
	private $invoiceInterface;
	/**
	 * @var OrderDetailStatus
	 */
	private $orderDetailStatus;
	/**
	 * @var OrderInterface
	 */
	private $orderInterface;

	/**
	 * @var CouponInterface
	 */
	private $couponInterface;

	/**
	 * @var Coupon
	 */

	private $coupon;

	/**
	 * AdminOrderDetailController constructor.
	 * @param OrderDetail $orderDetail
	 * @param OrderHeader $orderHeader
	 * @param CouponCustomerUsage $couponCustomerUsage
	 * @param InvoiceInterface $invoiceInterface
	 * @param OrderDetailStatus $orderDetailStatus
	 * @param OrderInterface $orderInterface
	 * @param CouponInterface $couponInterface
	 * @param Coupon $coupon
	 */
	public function __construct(OrderDetail $orderDetail,
	                            OrderHeader $orderHeader,
	                            InvoiceInterface $invoiceInterface,
	                            OrderDetailStatus $orderDetailStatus,
	                            OrderInterface $orderInterface,
								CouponCustomerUsage $couponCustomerUsage,
								CouponInterface $couponInterface,
								Coupon $coupon){

		$this->orderDetail = $orderDetail;
		$this->orderHeader = $orderHeader;
		$this->invoiceInterface = $invoiceInterface;
		$this->orderDetailStatus = $orderDetailStatus;
		$this->orderInterface = $orderInterface;
		$this->couponCustomerUsage  = $couponCustomerUsage;
		$this->couponInterface = $couponInterface;
		$this->coupon = $coupon;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

		Assets::add([
			URL::asset('js/order/EditOrderDetailCtrl.js') ,
			URL::asset('js/order/OrderSrvc.js'),
		]);

		Js::put(['id' => $id]);

		$orderDetail = $this->orderDetail->find($id);
		$orderHeaderId = $orderDetail->order_header_id;

		$orderHeader = $this->orderHeader->find($orderHeaderId);

		/* COUPON PER ITEM  (s)*/

		$couponPrice = 0;

		if($orderHeader->discount > 0){

			$storeWithCoupon = $this->getCustomerCouponUsage($orderHeader->customer_id);

			//\Session::put('couponCode', $storeWithCoupon['code']);
			$couponCode = $storeWithCoupon['code'];

			$discountedItems =($this->countDiscountedOrder($orderHeaderId,$storeWithCoupon['storeIdWithDiscount']));

			if($discountedItems > 0)
				$couponPrice = $this->computeCouponAmountPerItem($storeWithCoupon['discount'], $discountedItems, $orderDetail->qty);

		}

		/* COUPON PER ITEM  (e)*/


		
		$isInvoiceComplete = $this->invoiceInterface->isOrderDetailInvoiceComplete($id);

		$logs = $this->orderDetailStatus->whereOrderDetailId($id)->get();

//		$isShipmentComplete = $this->shipmentInterface->isShipmentComplete($id);
//		$isShipmentCancelled = $this->shipmentInterface->isShipmentCancelled($id);
//		$isInvoiceCancelled = $this->invoiceInterface->isInvoiceCancelled($id);

		$ctrl = 'EditOrderDetailCtrl';
		$title = 'Edit';

		$this->orderInterface->markAsNotModified($orderHeaderId);

		return view('admin.orderDetails.form', compact('ctrl', 'title', 'orderHeader', 'orderDetail', 'isInvoiceComplete', 'logs', 'couponCode'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function getCustomerCouponUsage($customerId){

		$couponId = $this->couponCustomerUsage->whereCustomerId($customerId)->pluck('coupon_id');
		$couponCode = $this->coupon->whereId($couponId)->pluck('code');
		return $this->couponInterface->getCoupon($couponCode);

	}

	public function countDiscountedOrder($orderHeaderId, $storeWithCoupon){
		$count =0;
		if($storeWithCoupon == null){
			$data =  $this->orderDetail->whereOrderHeaderId($orderHeaderId)->get();
			foreach($data as $row){
				$count+= $row->qty;
			}
//			$count =  $this->orderDetail->whereOrderHeaderId($orderHeaderId)->count();
		}else{
			$data = $this->orderDetail->whereOrderHeaderId($orderHeaderId)->get();
			foreach($data as $row){
				if($row->item->store_id == $storeWithCoupon){
					$count++;
				}
			}
		}
		return $count;
	}

	public function computeCouponAmountPerItem($coupounDiscount, $itemDiscounted, $orderQty){

		return ($coupounDiscount / $itemDiscounted) * $orderQty;

	}

}
