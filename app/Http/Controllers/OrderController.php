<?php namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\InvoiceDetail;
use App\InvoiceHeader;
use App\item;
use App\ItemSize;
use App\OrderDetail;
use App\OrderDetailStatus;
use App\OrderDetailTemp;
use App\OrderHeader;
use App\OrderHeaderTemp;
use App\OrderRecipient;
use App\Repositories\Invoice\Contracts\InvoiceInterface;
use App\Repositories\Order\Contracts\OrderInterface;
use App\Repositories\Shipment\Contracts\ShipmentInterface;
use App\ShipmentDetail;
use App\ShipmentHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

use Assets;
use JavaScript as Js;

class OrderController extends Controller {
	/**
	 * @var OrderHeader
	 */
	private $orderHeader;
	/**
	 * @var InvoiceHeader
	 */
	private $invoiceHeader;
	/**
	 * @var ShipmentHeader
	 */
	private $shipmentHeader;
	/**
	 * @var OrderDetail
	 */
	private $orderDetail;
	/**
	 * @var InvoiceInterface
	 */
	private $invoiceInterface;
	/**
	 * @var ShipmentInterface
	 */
	private $shipmentInterface;
	/**
	 * @var OrderInterface
	 */
	private $orderInterface;
	/**
	 * @var InvoiceHeader
	 */
	private $invoiceDetail;
	/**
	 * @var ShipmentHeader
	 */
	private $shipmentDetail;
	/**
	 * @var OrderDetailTemp
	 */
	private $orderDetailTemp;
	/**
	 * @var OrderHeaderTemp
	 */
	private $orderHeaderTemp;
	/**
	 * @var Customer
	 */
	private $customer;
	/**
	 * @var OrderRecipient
	 */
	private $orderRecipient;
	/**
	 * @var ItemSize
	 */
	private $itemSize;
	/**
	 * @var Item
	 */
	 private $item;
	/**
	 * @var OrderDetailStatus
	 */
	private $orderDetailStatus;


	/**
	 * @param OrderHeader $orderHeader
	 * @param ItemSize $itemSize
	 * @param OrderRecipient $orderRecipient
	 * @param OrderDetail $orderDetail
	 * @param InvoiceDetail $invoiceDetail
	 * @param OrderHeaderTemp $orderHeaderTemp
	 * @param OrderDetailTemp $orderDetailTemp
	 * @param InvoiceHeader $invoiceHeader
	 * @param ShipmentHeader $shipmentHeader
	 * @param ShipmentDetail $shipmentDetail
	 * @param OrderInterface $orderInterface
	 * @param InvoiceInterface $invoiceInterface
	 * @param ShipmentInterface $shipmentInterface
	 * @param OrderDetailStatus $orderDetailStatus
	 * @internal param Customer $customer
	 * @internal param InvoiceHeader $invoiceHeader
	 */
	public function __construct(OrderHeader $orderHeader,
						   Item $item,
	                            ItemSize $itemSize,
	                            OrderRecipient $orderRecipient,
	                            OrderDetail $orderDetail,
	                            InvoiceDetail $invoiceDetail,
	                            OrderHeaderTemp $orderHeaderTemp,
	                            OrderDetailTemp $orderDetailTemp,
	                            InvoiceHeader $invoiceHeader,
	                            ShipmentHeader $shipmentHeader,
	                            ShipmentDetail $shipmentDetail,
	                            OrderInterface $orderInterface,
	                            InvoiceInterface $invoiceInterface,
	                            ShipmentInterface $shipmentInterface,
	                            OrderDetailStatus $orderDetailStatus) {

		$this->orderHeader = $orderHeader;
		$this->orderDetail = $orderDetail;
		$this->invoiceInterface = $invoiceInterface;
		$this->shipmentInterface = $shipmentInterface;
		$this->orderInterface = $orderInterface;
		$this->invoiceDetail = $invoiceDetail;
		$this->shipmentDetail = $shipmentDetail;
		$this->invoiceHeader = $invoiceHeader;
		$this->shipmentHeader = $shipmentHeader;
		$this->orderDetailTemp = $orderDetailTemp;
		$this->orderHeaderTemp = $orderHeaderTemp;
		$this->orderRecipient = $orderRecipient;
		$this->itemSize = $itemSize;
		$this->item  = $item;
		$this->orderDetailStatus = $orderDetailStatus;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$data = $this->orderHeader->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));


		Assets::add([
			URL::asset('js/payment/PaymentSrvc.js'),
			URL::asset('js/email/EmailSrvc.js'),
			URL::asset('js/order/OrderSrvc.js'),
			URL::asset('js/order/OrderedItemsListCtrl.js'),
			URL::asset('js/order/OrderListCtrl.js'),
		]);

		$orderNumber = '';
		$customer = '';

		$paymentOption = '';
		$status = '';

		return view('admin.orders.list', compact('data', 'orderNumber', 'customer', 'paymentOption', 'status', 'orderHeader'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id) {
		$orderHeader = $this->orderHeader->find($id);
		$orderDetails = $this->orderDetail->whereOrderHeaderId($id)->get();

		return view('admin.orders.show', compact('ctrl', 'title', 'orderHeader', 'orderDetails'));

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($id) {
		Assets::add([
			URL::asset('js/order/EditOrderCtrl.js'),
			URL::asset('js/order/OrderSrvc.js'),
		]);

		Js::put(['id' => $id]);

		$orderHeader = $this->orderHeader->find($id);
		$orderDetails = $this->orderDetail->whereOrderHeaderId($id)->get();

		$isInvoiceComplete = $this->invoiceInterface->isInvoiceComplete($id);
		$isShipmentComplete = $this->shipmentInterface->isShipmentComplete($id);
		$isShipmentCancelled = $this->shipmentInterface->isShipmentCancelled($id);
		$isInvoiceCancelled = $this->invoiceInterface->isInvoiceCancelled($id);

		$ctrl = 'EditOrderCtrl';
		$title = 'Edit';

		return view('admin.orders.form', compact('ctrl', 'title', 'orderHeader', 'orderDetails', 'isInvoiceComplete', 'isShipmentComplete', 'isShipmentCancelled', 'isInvoiceCancelled'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param  int $id
	 * @return Response
	 */
	public function update(Request $request, $id) {
		$data = $request->all();

		unset($data['errors']);

		$orderHeader = $this->orderHeader->find($id);

		$isInvoiceComplete = $this->invoiceInterface->isInvoiceComplete($id);
		$isShipmentComplete = $this->shipmentInterface->isShipmentComplete($id);
		$isShipmentCancelled = $this->shipmentInterface->isShipmentCancelled($id);
		$isInvoiceCancelled = $this->invoiceInterface->isInvoiceCancelled($id);

		if (!$isInvoiceComplete && !$isShipmentComplete) {
			$data['option_order_status_id'] = \Config::get('constants.orderStatusPending');
		} elseif ($isShipmentCancelled && $isInvoiceCancelled) {
			$data['option_order_status_id'] = \Config::get('constants.orderVoidStatus');
		} else {
			$data['option_order_status_id'] = \Config::get('constants.orderCompleteStatus');
		}

		$orderHeader->fill($data)
			->save();

		return ['id' => $id];
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id) {
		//
		// //order header
		// $orderHeader = $this->orderHeader->find($id);
		// $oH_Id = $orderHeader->id;
		// $oH_orderRecipientId = $orderHeader->order_recipient_id;
		// $oH_customerId = $orderHeader->customer_id;
		//
		//  //order_detail status and shipmentHeader
		// $shipmentHeader = $this->shipmentHeader->where('order_header_id', $oH_Id);
		// $orderDetail = $this->orderDetail->where('order_header_id', $oH_Id);
		// //$this->orderInterface->returnStock($orderHeader->order_header_id);
		//
		// foreach($orderDetail as $oD){
		//
		// 	$Od_Id = $oD->id;
		// 	//order_detail status
		// 	$orderDetailStatus = $this->orderDetailStatus->where('order_detail_id',$Od_Id);
		// 	$orderDetailStatus->delete();
		// 	//shipmentDetail
		// 	$shipmentDetail = $this->shipmentDetail->where('order_detail_id',$Od_Id);
		// 	$shipmentDetail->delete();
		//
		// }
		//
		// $orderHeaderTemp = $this->orderHeaderTemp->where('customer_id',$oH_customerId);
		//
		// foreach($orderHeaderTemp as $oHt){
		// 	$oHt_Id = $oHt->id;
		// 	//orderDetailTemp
		// 	$orderDetailTemp = $this->orderDetailTemp->where('order_header_temp_id', $oHt_Id);
		// 	$orderDetailTemp->delete();
		// }
		// $shipmentHeader->delete();
		// $orderHeaderTemp->delete();
		// $orderDetail->delete();
	    // $orderHeader->delete();
		//
		// return redirect('/admin/orders');


	}

	public function getRecord($id) {
		return $this->orderHeader->find($id);
	}

	/**
	 * @param Request $request
	 * @param  int $id
	 * @return Response
	 */
	public function delete(Request $request) {
		$data = $request->all();

		//get order_header
		$order = $this->orderHeader->find($data['orderHeaderId']);


//		$order_temp = $this->orderDetailTemp->find($data['orderHeaderId']);

		//Return item qty


			$this->orderInterface->returnStock($order->id);

		//Delete order temps
//		$order_temp->destroy($order_temp->id);
//		$order_temp->destroy($order_temp->order_header_temp_id);

		//Delete order
		$order->destroy($order->id);

		//Delete order recipient

		$this->orderRecipient->destroy($order->order_recipient_id);


	}

	/**
	 * @param Request $request
	 * @param  int $id
	 * @return Response
	 */
	public function cancel(Request $request) {

		$data = $request->all();

		//$order = $this->orderHeader->find($data['orderHeaderId']);

		$orderDetail = $this->orderDetail->find($data['orderHeaderId']);

		//Return item qty
		//
		$this->orderInterface->returnOrderStock($orderDetail->id);


		// $this->item->whereId($orderDetail->item_id)->increment('qty', $orderDetail->qty);
		// $this->itemSize->whereItemId($orderDetail->item_id)->whereOptionSizeId($orderDetail->option_size_id)->increment('stock', $orderDetail->qty);




		//$order->option_order_status_id = \Config::get('constants.orderVoidStatus');
		$orderDetail->option_order_status_id = \Config::get('constants.orderVoidStatus');
		$orderDetail->save();

		$od_item_id = $orderDetail->item_id;
		$od_option_size_id = $orderDetail->option_size_id;




		//cancel of order
		$oh_id = $orderDetail->order_header_id;

		 //count the number of order
		$orderCount = $this->orderDetail
			->where('order_header_id',$oh_id)
			->count();

		 //count the number of order where status is cancelled
		$orderCountCancelled = $this->orderDetail
			->where('order_header_id',$oh_id)
			->where('option_order_status_id',\Config::get('constants.orderVoidStatus'))
			->count();

		if($orderCount == $orderCountCancelled){

			$order= $this->orderHeader->find($oh_id);
			$order->option_order_status_id = \Config::get('constants.orderVoidStatus');
			$order->save();

		}
		//


		// $this->returnItemStock($data['orderHeaderId']);

		$this->markAsComplete($orderDetail->id);

	}


	public function search(Request $request) {

		$req = $request->all();

		Assets::add([
			URL::asset('js/payment/PaymentSrvc.js'),
			URL::asset('js/email/EmailSrvc.js'),
			URL::asset('js/order/OrderSrvc.js'),
			URL::asset('js/order/OrderedItemsListCtrl.js'),
			URL::asset('js/order/OrderListCtrl.js'),
		]);

		$orderNumber = (isset($req['orderNumber'])) ? $req['orderNumber'] : '';
		$customer = (isset($req['customer'])) ? $req['customer'] : '';
		$paymentOption = (isset($req['paymentOption'])) ? $req['paymentOption'] : '';
		$status = (isset($req['status'])) ? $req['status'] : '';

		$data = $this->orderHeader->searchOrderNumber($orderNumber)
			->searchCustomer($customer)
			->searchPaymentOption($paymentOption)
			->searchStatusOption($status)
			->orderBy('id', 'desc')
			->paginate(\Config::get('constants.paginationLimit'));

		return view('admin.orders.list', compact('data', 'orderNumber', 'customer', 'paymentOption', 'status'));

	}

	/**
	 * Get list of ordered items
	 * @param $orderHeaderId
	 */
	public function getOrderedItems($orderHeaderId) {
		return $this->orderDetail->with('item')->whereOrderHeaderId($orderHeaderId)->get();
	}

	/**
	 * Get order by orderHeaderId
	 * @param $orderHeaderId
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getOrder($orderHeaderId) {
		return $this->orderHeader->whereId($orderHeaderId)->with('orderDetail.item')->first();
	}

	/**
	 * Mark order detail as verified..
	 * Verified order details will show in merchant view
	 * @param $orderDetailId
	 * @return array
	 */
	public function verifyOrderDetail($orderDetailId) {

		$r = $this->orderDetail->find($orderDetailId);

		$r->option_order_status_id = \Config::get('constants.orderVerifiedStatus');

		$r->save();

		$this->orderInterface->saveOrderStatus($orderDetailId, \Config::get('constants.orderVerifiedStatus'));

		return ['status' => 'success'];

	}

	/**
	 * @param $orderDetailId
	 * @return array
	 */
	public function acceptOrderDetail($orderDetailId) {

		$r = $this->orderDetail->find($orderDetailId);

		$r->option_order_status_id = \Config::get('constants.orderAcceptedStatus');

		$r->save();

		$this->orderInterface->saveOrderStatus($orderDetailId, \Config::get('constants.orderAcceptedStatus'));

		$this->orderInterface->markAsModified($orderDetailId);

		return ['status' => 'success'];
	}

	/**
	 * @param Request $request
	 * @param $orderDetailId
	 * @return array
	 */
	public function rejectOrderDetail(Request $request, $orderDetailId) {

		$data = $request->all();


		$r = $this->orderDetail->find($orderDetailId);

		$r->option_order_status_id = \Config::get('constants.orderRejectedStatus');

		$r->save();

//		$this->orderInterface->saveOrderStatus($orderDetailId, \Config::get('constants.orderRejectedStatus'));

		$note = isset($data['note']) ? $data['note'] : '';

		$d = [
			'order_detail_id'        => $orderDetailId,
			'option_order_status_id' => \Config::get('constants.orderRejectedStatus'),
			'note'                   => $note,
		];

		$this->orderDetailStatus->create($d);

		$this->orderInterface->markAsModified($orderDetailId);

		$this->returnItemStock($orderDetailId);

		$this->markAsComplete($orderDetailId);

		return ['status' => 'success'];
	}

	/**
	 * @param $orderDetailId
	 * @return array
	 */
	public function shipOrderDetail($orderDetailId) {

		$r = $this->orderDetail->find($orderDetailId);

		$r->option_order_status_id = \Config::get('constants.orderShippedStatus');

		$r->save();

		$this->orderInterface->saveOrderStatus($orderDetailId, \Config::get('constants.orderShippedStatus'));

		$this->orderInterface->markAsModified($orderDetailId);

		$this->markAsComplete($orderDetailId);

		return ['status' => 'success'];
	}

	/**
	 * @param $orderDetailId
	 * @return array
	 */
	public function markAsPaidOrderDetail($orderDetailId) {

		$r = $this->orderDetail->find($orderDetailId);

		$r->option_order_status_id = \Config::get('constants.orderPaidStatus');

		$r->save();

		$this->orderInterface->saveOrderStatus($orderDetailId, \Config::get('constants.orderPaidStatus'));

		return ['status' => 'success'];
	}

	/**
	 * Check if order details are all shipped/rejected. If yes, mark order header as complete
	 * @param $orderDetailId
	 */
	public function markAsComplete($orderDetailId) {

		$o = $this->orderDetail->find($orderDetailId);

		$orderHeaderId = $o->order_header_id;

		/*Get all order details using orderHeaderId*/
		$orderDetails = $this->orderDetail->whereOrderHeaderId($orderHeaderId)->get();

		$orderCount = $orderDetails->count();
		$isComplete = 0;

		foreach ($orderDetails as $od) {

			if ($od['option_order_status_id'] == \Config::get('constants.orderShippedStatus')
			|| $od['option_order_status_id'] == \Config::get('constants.orderRefundStatus')
			|| $od['option_order_status_id'] == \Config::get('constants.orderExchangeStatus')
			|| $od['option_order_status_id'] == \Config::get('constants.orderRejectedStatus')
			|| $od['option_order_status_id'] == \Config::get('constants.orderVoidStatus')) {
				$isComplete ++;
			}

		}

		$order= $this->orderHeader->find($orderHeaderId);
		$order_stautus  = $order->option_order_status_id;

		// if the order status not equal to 3 then continue to completetion of orders
		if($order_stautus != \Config::get('constants.orderVoidStatus'))
		{
			if ($isComplete == $orderCount) {

				$oh = $this->orderHeader->find($orderHeaderId);
				$oh->option_order_status_id = \Config::get('constants.orderCompleteStatus');

				$oh->save();

				$this->orderInterface->saveOrderStatus($orderDetailId, \Config::get('constants.orderCompleteStatus'));
			}
		}

		return;


	}

	public function refundOrderDetail($orderDetailId) {

		$r = $this->orderDetail->find($orderDetailId);

		$r->option_order_status_id = \Config::get('constants.orderRefundStatus');

		$r->save();

		$this->orderInterface->saveOrderStatus($orderDetailId, \Config::get('constants.orderRefundStatus'));


		$this->returnItemStock($orderDetailId);

		$this->markAsComplete($orderDetailId);

		return ['status' => 'success'];

	}

	public function exchangeOrderDetail($orderDetailId) {

		$r = $this->orderDetail->find($orderDetailId);

		$r->option_order_status_id = \Config::get('constants.orderExchangeStatus');

		$r->save();

		$this->orderInterface->saveOrderStatus($orderDetailId, \Config::get('constants.orderExchangeStatus'));

		//$this->returnItemStock($orderDetailId);

		$this->markAsComplete($orderDetailId);

		return ['status' => 'success'];

	}

	public function returnItemStock($orderDetailId){

		$orderHeaderId =$this->orderDetail->whereId($orderDetailId)->pluck('order_header_id');
		$this->orderInterface->returnStock($orderHeaderId);

	}

}
