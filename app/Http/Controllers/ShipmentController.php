<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OrderDetail;
use App\OrderHeader;
use App\Repositories\Invoice\Contracts\InvoiceInterface;
use App\Repositories\Shipment\Contracts\ShipmentInterface;
use App\ShipmentDetail;
use App\ShipmentHeader;
use Illuminate\Http\Request;
use Assets;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Input;
use URL;
use JavaScript as Js;

class ShipmentController extends Controller {
	/**
	 * @var ShipmentHeader
	 */
	private $shipmentHeader;
	/**
	 * @var ShipmentDetail
	 */
	private $shipmentDetail;
	/**
	 * @var OrderHeader
	 */
	private $orderHeader;
	/**
	 * @var OrderDetail
	 */
	private $orderDetail;
	/**
	 * @var ShipmentInterface
	 */
	private $shipmentInterface;
	/**
	 * @var InvoiceInterface
	 */
	private $invoiceInterface;


	/**
	 * @param ShipmentInterface $shipmentInterface
	 * @param InvoiceInterface $invoiceInterface
	 * @param ShipmentHeader $shipmentHeader
	 * @param ShipmentDetail $shipmentDetail
	 * @param OrderHeader $orderHeader
	 * @param OrderDetail $orderDetail
	 */
	public function __construct(ShipmentInterface $shipmentInterface, InvoiceInterface $invoiceInterface, ShipmentHeader $shipmentHeader, ShipmentDetail $shipmentDetail, OrderHeader $orderHeader, OrderDetail $orderDetail){

		$this->shipmentHeader = $shipmentHeader;
		$this->shipmentDetail = $shipmentDetail;
		$this->orderHeader = $orderHeader;
		$this->orderDetail = $orderDetail;
		$this->shipmentInterface = $shipmentInterface;

		$this->executeMiddlewares();
		$this->invoiceInterface = $invoiceInterface;
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
			URL::asset('js/shipment/ShipmentListCtrl.js'),
			URL::asset('js/shipment/ShipmentSrvc.js'),
		]);

		$data = $this->shipmentHeader->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));

		return view('admin.shipments.list', compact('data'));
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
			URL::asset('js/shipment/AddShipmentCtrl.js'),
			URL::asset('js/shipment/ShipmentSrvc.js'),
		]);

		$ctrl = 'AddShipmentCtrl';
		$title = 'Add';

		$orderHeader = $this->orderHeader->find($orderHeaderId);

		$orderDetails = $this->orderDetail->whereOrderHeaderId($orderHeaderId);

		return view('admin.shipments.form', compact('ctrl', 'title', 'orderHeader', 'orderDetails'));

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


		/*Shipment header*/
		$shipmentNumber = date('Ymd') . "-" . time();
		$totalQtyShipped = $this->shipmentInterface->computeTotalQtyToShip($data['shipmentDetails']['qtyToShip']);

		$shipmentHeader = [
			'order_header_id' => $data['order_header_id'],
			'shipment_number' => $shipmentNumber,
			'qty' => $totalQtyShipped,
		];

		$r = $this->shipmentHeader->create($shipmentHeader);


		/*Shipment details*/
		foreach($data['orderDetails'] as $key => $od){

			$qty = $data['shipmentDetails']['qtyToShip'][$od['id']];

			$trackingNumber = 'N/A';

			if( isset($data['shipmentDetails']['trackingNumber'][$od['id']])){
				$trackingNumber = $data['shipmentDetails']['trackingNumber'][$od['id']];
			}


			$shipmentDetails[] = [
				'shipment_header_id' => $r->id,
				'order_detail_id' => $od['id'],
				'qty' => $qty,
				'tracking_number' => $trackingNumber
			];
		}

		foreach($shipmentDetails as $id){
			$this->shipmentDetail->create($id);
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
		$shipment = $this->shipmentHeader->find($id);

		Assets::add([
			URL::asset('js/shipment/ViewShipmentCtrl.js'),
			URL::asset('js/email/EmailSrvc.js'),
			URL::asset('js/shipment/ShipmentSrvc.js')
		]);

		Js::put(['id' => $id]);

		return view('admin.shipments.display', compact('shipment'));
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
		$this->shipmentHeader->destroy($id);
	}

	public function getShipmentForm($orderHeaderId) {
		$order = $this->orderHeader->with('orderDetail')->find($orderHeaderId);

		$shippedQty = $this->shipmentInterface->computeSumShipmentDetails($order->orderDetail, $this->shipmentDetail);

		$qtyLeft = $this->shipmentInterface->computeQtyLeft($order->orderDetail, $shippedQty);

		$shipmentForm = $this->shipmentInterface->createShipmentForm($order->orderDetail, $qtyLeft);

		return $shipmentForm;

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

		$shipment = $this->shipmentHeader->find($data['shipmentHeaderId']);

		$shipment->is_email_sent = 1;

		$shipment->save();
	}

	public function search(Request $request){

		$req = $request->all();

		$orderNumber = (isset($req['orderNumber'])) ? $req['orderNumber'] : '';
		$customer = (isset($req['customer'])) ? $req['customer'] : '';

		Assets::add([
			URL::asset('js/shipment/ShipmentListCtrl.js'),
			URL::asset('js/shipment/ShipmentSrvc.js'),
		]);

		$data = $this->shipmentHeader
			->searchOrderNumber($orderNumber)
			->searchCustomer($customer)
			->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));
		return view('admin.shipments.list', compact('data', 'orderNumber', 'customer'));
	}

}
