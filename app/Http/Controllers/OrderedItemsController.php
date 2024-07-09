<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OrderDetail;
use App\OrderHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Assets;
use Illuminate\Support\Facades\URL;
use JavaScript as Js;

class OrderedItemsController extends Controller {
	/**
	 * @var OrderDetail
	 */
	private $orderDetail;
	/**
	 * @var OrderHeader
	 */
	private $orderHeader;

	/**
	 * @param OrderDetail $orderDetail
	 * @param OrderHeader $orderHeader
	 */
	public function __construct(OrderDetail $orderDetail, OrderHeader $orderHeader){

		$this->orderDetail = $orderDetail;
		$this->orderHeader = $orderHeader;
		$this->storeId = Auth::user()->get()->store_id;

	}

	public function index() {

		Assets::add([
			URL::asset('js/order/OrderedItemsListCtrl.js'),
			URL::asset('js/order/OrderSrvc.js'),
		]);

		$data = $this->orderDetail->whereHas('item', function ($query) {
			$query->whereStoreId($this->storeId);
		})->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));


//		$data = $this->orderDetail->whereHas('item', function($q)
//		{
//			$q->whereStoreId($this->storeId);
//
//		})->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));

		return view('admin.orderedItems.list', compact('data'));
	}

	public function edit($id) {


		$orderHeader = $this->orderHeader->find($id);
//		$orderDetails = $this->orderDetail->whereOrderHeaderId($id)->get();
//
//		$isInvoiceComplete = $this->invoiceInterface->isInvoiceComplete($id);
//		$isShipmentComplete = $this->shipmentInterface->isShipmentComplete($id);
//		$isShipmentCancelled = $this->shipmentInterface->isShipmentCancelled($id);
//		$isInvoiceCancelled = $this->invoiceInterface->isInvoiceCancelled($id);
//
//		$ctrl = 'EditOrderCtrl';
//		$title = 'Edit';

		return view('admin.orderedItems.show', compact('orderHeader'));
	}
	
}
