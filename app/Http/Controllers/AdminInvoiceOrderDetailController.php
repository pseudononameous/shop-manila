<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\InvoiceDetail;
use App\InvoiceHeader;
use App\OrderDetail;
use App\OrderDetailStatus;
use App\OrderHeader;
use App\CouponCustomerUsage;
use App\Coupon;


use App\Repositories\Invoice\Contracts\InvoiceInterface;
use App\Repositories\Order\Contracts\OrderInterface;
use App\Repositories\Coupon\Contracts\CouponInterface;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;

use Assets;
use JavaScript as Js;

class AdminInvoiceOrderDetailController extends Controller {
	/**
	 * @var OrderDetail
	 */
	private $orderDetail;
	/**
	 * @var OrderHeader
	 */
	private $orderHeader;
	/**
	 * @var InvoiceInterface
	 */
	private $invoiceInterface;
	/**
	 * @var InvoiceDetail
	 */
	private $invoiceDetail;
	/**
	 * @var InvoiceHeader
	 */
	private $invoiceHeader;
	/**
	 * @var OrderDetailStatus
	 */
	private $orderDetailStatus;
	/**
	 * @var OrderInterface
	 */
	private $orderInterface;

	private $couponInterface;
	private $couponCustomerUsage;
	private $coupon;

	/**
	 * AdminInvoiceOrderDetailController constructor.
	 * @param OrderDetail $orderDetail
	 * @param OrderHeader $orderHeader
	 * @param InvoiceInterface $invoiceInterface
	 * @param InvoiceHeader $invoiceHeader
	 * @param InvoiceDetail $invoiceDetail
	 * @param OrderDetailStatus $orderDetailStatus
	 * @param OrderInterface $orderInterface
	 */
	public function __construct(OrderDetail $orderDetail,
	                            OrderHeader $orderHeader,
	                            InvoiceInterface $invoiceInterface,
	                            InvoiceHeader $invoiceHeader,
	                            InvoiceDetail $invoiceDetail,
	                            OrderDetailStatus $orderDetailStatus,
	                            OrderInterface $orderInterface,
								CouponCustomerUsage $couponCustomerUsage,
								CouponInterface $couponInterface,
								Coupon $coupon) {

		$this->orderDetail = $orderDetail;
		$this->orderHeader = $orderHeader;
		$this->invoiceInterface = $invoiceInterface;
		$this->invoiceDetail = $invoiceDetail;
		$this->invoiceHeader = $invoiceHeader;
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
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		$orderDetailId = Input::get('orderDetailId');

		Js::put(['orderDetailId' => $orderDetailId]);

		Assets::add([
			URL::asset('js/invoiceOrderDetail/AddInvoiceOrderDetailCtrl.js'),
			URL::asset('js/invoiceOrderDetail/InvoiceSrvc.js'),
		]);

		$ctrl = 'AddInvoiceOrderDetailCtrl';
		$title = 'Add';

		$orderDetail = $this->orderDetail->find($orderDetailId);

		$orderHeaderId = $orderDetail->order_header_id;
		$orderHeader = $this->orderHeader->find($orderHeaderId);



		/* COUPON PER ITEM  (s)*/

		$couponPrice = 0;

		if($orderHeader->discount > 0){

			$storeWithCoupon = $this->getCustomerCouponUsage($orderHeader->customer_id);

		//	\Session::put('couponCode', $storeWithCoupon['code']);
			$couponCode = $storeWithCoupon['code'];

			$discountedItems =($this->countDiscountedOrder($orderHeaderId,$storeWithCoupon['storeIdWithDiscount']));

			if($discountedItems > 0)
				$couponPrice = $this->computeCouponAmountPerItem($storeWithCoupon['discount'], $discountedItems, $orderDetail->qty);

		}

		Js::put(['couponPrice' => $couponPrice]);

		/* COUPON PER ITEM  (e)*/



		return view('admin.invoiceOrderDetails.form', compact('ctrl', 'title', 'orderHeader', 'orderDetail', 'couponCode'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request) {
		$data = $request->all();

		$orderDetail = $this->orderDetail->find($data['orderDetailId']);
		$orderHeaderId = $orderDetail->order_header_id;

		/*Invoice header*/
		$invoiceNumber = date('Ymd') . "-" . time();
		$totalQtyInvoiced = $this->invoiceInterface->computeTotalQtyToInvoice($data['invoiceDetails']['qtyToInvoice']);
		$totalAmountInvoiced = $this->invoiceInterface->computeTotalAmountToInvoice($data['orderDetails'], $data['invoiceDetails']['qtyToInvoice']);

		$invoiceHeader = [
			'order_header_id' => $orderHeaderId,
			'invoice_number'  => $invoiceNumber,
			'qty'             => $totalQtyInvoiced,
			'amount'          => $totalAmountInvoiced,
		];

		$r = $this->invoiceHeader->create($invoiceHeader);


		/*Invoice details*/
		foreach ($data['orderDetails'] as $key => $od) {

			$qty = $data['invoiceDetails']['qtyToInvoice'][ $od['id'] ];

			$amount = $qty * $od['price'];

			$invoiceDetails[] = [
				'invoice_header_id' => $r->id,
				'order_detail_id'   => $od['id'],
				'qty'               => $qty,
				'amount'            => $amount,
			];
		}

		foreach ($invoiceDetails as $id) {
			$this->invoiceDetail->create($id);
		}


		$this->markOrderDetailAsInvoiced($data['orderDetailId']);

		return ['id' => $r->id];

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function update($id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id) {
		$this->invoiceHeader->destroy($id);
	}


	public function getInvoiceForm($orderDetailId) {
//		$order = $this->orderHeader->with('orderDetail')->find($orderHeaderId);

		$order = $this->orderDetail->find($orderDetailId);

		$invoicedQty = $this->invoiceInterface->computeSumInvoiceDetails($order, $this->invoiceDetail, 'orderDetail');

		$qtyLeft = $this->invoiceInterface->computeQtyLeft($order, $invoicedQty, 'orderDetail');

		$invoiceForm = $this->invoiceInterface->createInvoiceForm($order, $qtyLeft, 'orderDetail');

		return $invoiceForm;

	}

	public function markOrderDetailAsInvoiced($orderDetailId) {
		$r = $this->orderDetail->find($orderDetailId);

		$r->option_order_status_id = \Config::get('constants.orderInvoicedStatus');

		$r->save();

		$this->orderInterface->saveOrderStatus($orderDetailId, \Config::get('constants.orderInvoicedStatus'));

		return;
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
