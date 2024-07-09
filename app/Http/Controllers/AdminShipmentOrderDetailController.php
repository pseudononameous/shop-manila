<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OrderDetail;
use App\OrderHeader;
use App\Repositories\Order\Contracts\OrderInterface;
use App\Repositories\Shipment\Contracts\ShipmentInterface;
use App\ShipmentDetail;
use App\ShipmentHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Assets;
use Illuminate\Support\Facades\URL;
use JavaScript as Js;

class AdminShipmentOrderDetailController extends Controller {
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
	 * @var ShipmentDetail
	 */
	private $shipmentDetail;
	/**
	 * @var ShipmentHeader
	 */
	private $shipmentHeader;
	/**
	 * @var OrderInterface
	 */
	private $orderInterface;

	/**
	 * AdminShipmentOrderDetailController constructor.
	 * @param OrderHeader $orderHeader
	 * @param OrderDetail $orderDetail
	 * @param ShipmentInterface $shipmentInterface
	 * @param ShipmentDetail $shipmentDetail
	 * @param ShipmentHeader $shipmentHeader
	 * @param OrderInterface $orderInterface
	 */
	public function __construct(OrderHeader $orderHeader,
	                            OrderDetail $orderDetail,
	                            ShipmentInterface $shipmentInterface,
	                            ShipmentDetail $shipmentDetail,
	                            ShipmentHeader $shipmentHeader,
	                            OrderInterface $orderInterface) {

		$this->orderHeader = $orderHeader;
		$this->orderDetail = $orderDetail;
		$this->shipmentInterface = $shipmentInterface;
		$this->shipmentDetail = $shipmentDetail;
		$this->shipmentHeader = $shipmentHeader;
		$this->orderInterface = $orderInterface;
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
			URL::asset('js/shipmentOrderDetail/AddShipmentOrderDetailCtrl.js'),
			URL::asset('js/shipmentOrderDetail/ShipmentSrvc.js'),
		]);

		$ctrl = 'AddShipmentOrderDetailCtrl';
		$title = 'Add';

		$orderDetail = $this->orderDetail->find($orderDetailId);

		$orderHeaderId = $orderDetail->order_header_id;
		$orderHeader = $this->orderHeader->find($orderHeaderId);

		return view('admin.shipmentOrderDetails.form', compact('ctrl', 'title', 'orderHeader', 'orderDetail'));
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


		/*Shipment header*/
		$shipmentNumber = date('Ymd') . "-" . time();
		$totalQtyShipped = $this->shipmentInterface->computeTotalQtyToShip($data['shipmentDetails']['qtyToShip']);

		$shipmentHeader = [
			'order_header_id' => $orderHeaderId,
			'shipment_number' => $shipmentNumber,
			'qty'             => $totalQtyShipped,
		];

		$r = $this->shipmentHeader->create($shipmentHeader);


		/*Shipment details*/
		foreach ($data['orderDetails'] as $key => $od) {

			$qty = $data['shipmentDetails']['qtyToShip'][ $od['id'] ];

			$trackingNumber = 'N/A';

			if (isset($data['shipmentDetails']['trackingNumber'][ $od['id'] ])) {
				$trackingNumber = $data['shipmentDetails']['trackingNumber'][ $od['id'] ];
			}


			$shipmentDetails[] = [
				'shipment_header_id' => $r->id,
				'order_detail_id'    => $od['id'],
				'qty'                => $qty,
				'tracking_number'    => $trackingNumber,
			];
		}

		foreach ($shipmentDetails as $id) {
			$this->shipmentDetail->create($id);
		}

		$this->markOrderDetailAsShipped($data['orderDetailId']);

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
		$this->shipmentHeader->destroy($id);
	}

	public function getShipmentForm($orderDetailId) {
		$order = $this->orderDetail->find($orderDetailId);

		$shippedQty = $this->shipmentInterface->computeSumShipmentDetails($order, $this->shipmentDetail, 'orderDetail');

		$qtyLeft = $this->shipmentInterface->computeQtyLeft($order, $shippedQty, 'orderDetail');

		$shipmentForm = $this->shipmentInterface->createShipmentForm($order, $qtyLeft, 'orderDetail');

		return $shipmentForm;

	}


	public function markOrderDetailAsShipped($orderDetailId) {
		$r = $this->orderDetail->find($orderDetailId);

		$r->option_order_status_id = \Config::get('constants.orderPickupStatus');

		$r->save();

		$this->orderInterface->saveOrderStatus($orderDetailId, \Config::get('constants.orderPickupStatus'));
		
		return;
	}


}
