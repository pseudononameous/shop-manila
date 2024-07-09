<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\InvoiceDetail;
use App\InvoiceHeader;
use App\OrderDetail;
use App\OrderHeader;
use App\CouponCustomerUsage;
use App\Coupon;
use App\Repositories\Invoice\Contracts\InvoiceInterface;
use App\Repositories\Shipment\Contracts\ShipmentInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Assets;
use URL;
use JavaScript as Js;

class InvoiceController extends Controller {

	/**
	 * @var OrderHeader
	 */
	private $orderHeader;
	/**
	 * @var OrderDetail
	 */
	private $orderDetail;
	/**
	 * @var InvoiceDetail
	 */
	private $invoiceDetail;
	/**
	 * @var InvoiceInterface
	 */
	private $invoiceInterface;
	/**
	 * @var InvoiceHeader
	 */
	private $invoiceHeader;
	/**
	 * @var ShipmentInterface
	 */
	private $shipmentInterface;

	/**
	 * @param OrderHeader $orderHeader
	 * @param OrderDetail $orderDetail
	 * @param InvoiceHeader $invoiceHeader
	 * @param InvoiceDetail $invoiceDetail
	 * @param InvoiceInterface $invoiceInterface
	 * @param ShipmentInterface $shipmentInterface
	 */

	private $couponCustomerUsage;
	private $coupon;

	public function __construct(OrderHeader $orderHeader, OrderDetail $orderDetail, InvoiceHeader $invoiceHeader,
								InvoiceDetail $invoiceDetail, InvoiceInterface $invoiceInterface,
								ShipmentInterface $shipmentInterface, Coupon $coupon, CouponCustomerUsage $couponCustomerUsage){

		$this->orderHeader = $orderHeader;
		$this->orderDetail = $orderDetail;
		$this->invoiceDetail = $invoiceDetail;
		$this->invoiceInterface = $invoiceInterface;
		$this->invoiceHeader = $invoiceHeader;
		$this->couponCustomerUsage  = $couponCustomerUsage;
		$this->coupon = $coupon;


		$this->executeMiddlewares();
		$this->shipmentInterface = $shipmentInterface;
	}

	public function executeMiddlewares() {
		$this->middleware('adminOnly');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Assets::add([
			URL::asset('js/invoice/InvoiceListCtrl.js'),
			URL::asset('js/invoice/InvoiceSrvc.js'),
		]);

		$data = $this->invoiceHeader->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));

		return view('admin.invoices.list', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		$orderHeaderId = Input::get('orderHeaderId');

		Js::put(['orderHeaderId' => $orderHeaderId]);

		Assets::add([
			URL::asset('js/invoice/AddInvoiceCtrl.js'),
			URL::asset('js/invoice/InvoiceSrvc.js'),
		]);

		$ctrl = 'AddInvoiceCtrl';
		$title = 'Add';

		$orderHeader = $this->orderHeader->find($orderHeaderId);

		$orderDetails = $this->orderDetail->whereOrderHeaderId($orderHeaderId);

		return view('admin.invoices.form', compact('ctrl', 'title', 'orderHeader', 'orderDetails'));

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{

		$data = $request->all();


		/*Invoice header*/
		$invoiceNumber = date('Ymd') . "-" . time();
		$totalQtyInvoiced = $this->invoiceInterface->computeTotalQtyToInvoice($data['invoiceDetails']['qtyToInvoice']);
		$totalAmountInvoiced = $this->invoiceInterface->computeTotalAmountToInvoice($data['orderDetails'], $data['invoiceDetails']['qtyToInvoice']);

		$invoiceHeader = [
			'order_header_id' => $data['order_header_id'],
			'invoice_number' => $invoiceNumber,
			'qty' => $totalQtyInvoiced,
			'amount' => $totalAmountInvoiced
		];

		$r = $this->invoiceHeader->create($invoiceHeader);


		/*Invoice details*/
		foreach($data['orderDetails'] as $key => $od){

			$qty = $data['invoiceDetails']['qtyToInvoice'][$od['id']];

			$amount = $qty * $od['price'];

			$invoiceDetails[] = [
				'invoice_header_id' => $r->id,
				'order_detail_id' => $od['id'],
				'qty' => $qty,
				'amount' => $amount
			];
		}

		foreach($invoiceDetails as $id){
			$this->invoiceDetail->create($id);
		}


		$this->markOrderAsComplete($data['order_header_id']);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		$invoice = $this->invoiceHeader->find($id);

		if($invoice->orderHeader->discount > 0) {
			$couponId = $this->couponCustomerUsage->whereCustomerId($invoice->orderHeader->customer_id)->pluck('coupon_id');
			$couponCode = $this->coupon->whereId($couponId)->pluck('code');
		}


		Assets::add([
			URL::asset('js/invoice/ViewInvoiceCtrl.js'),
			URL::asset('js/invoice/InvoiceSrvc.js'),
			URL::asset('js/email/EmailSrvc.js')
		]);

		Js::put(['id' => $id]);

		return view('admin.invoices.display', compact('invoice', 'couponCode'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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

		$this->markOrderDetailAsPending($id);

		$this->invoiceHeader->destroy($id);

	}

	public function markOrderDetailAsPending($invoiceHeaderId) {
		$id = $this->invoiceDetail->whereInvoiceHeaderId($invoiceHeaderId)->first();

		$orderDetailId = $id['order_detail_id'];

		$od = $this->orderDetail->find($orderDetailId);

		$od->option_order_status_id = \Config::get('constants.orderStatusPending');

		$od->save();

		return;
	}

	public function getInvoiceForm($orderHeaderId) {
		$order = $this->orderHeader->with('orderDetail')->find($orderHeaderId);

		$invoicedQty = $this->invoiceInterface->computeSumInvoiceDetails($order->orderDetail, $this->invoiceDetail);

		$qtyLeft = $this->invoiceInterface->computeQtyLeft($order->orderDetail, $invoicedQty);

		$invoiceForm = $this->invoiceInterface->createInvoiceForm($order->orderDetail, $qtyLeft);

		return $invoiceForm;

	}

	public function markOrderAsComplete($orderHeaderId) {


		$isInvoiceComplete = $this->invoiceInterface->isInvoiceComplete($orderHeaderId);
		$isShipmentComplete = $this->shipmentInterface->isShipmentComplete($orderHeaderId);

		if($isInvoiceComplete && $isShipmentComplete){

			$r = $this->orderHeader->find($orderHeaderId);
			$r->option_order_status_id = \Config::get('constants.orderCompleteStatus');
			$r->save();

		}

	}

	public function markAsEmailSent(Request $request)
	{
		$data = $request->all();

		$invoice = $this->invoiceHeader->find($data['invoiceHeaderId']);

		$invoice->is_email_sent = 1;

		$invoice->save();
	}

	public function search(Request $request){

		$req = $request->all();

		$orderNumber = (isset($req['orderNumber'])) ? $req['orderNumber'] : '';
		$customer = (isset($req['customer'])) ? $req['customer'] : '';

		Assets::add([
			URL::asset('js/invoice/InvoiceListCtrl.js'),
			URL::asset('js/invoice/InvoiceSrvc.js'),
		]);

		$data = $this->invoiceHeader
			->searchOrderNumber($orderNumber)
			->searchCustomer($customer)
			->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));

		return view('admin.invoices.list', compact('data','orderNumber' ,'customer'));
	}



}
