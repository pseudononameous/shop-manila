<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\InvoiceHeader;
use App\OrderHeader;
use App\ShipmentHeader;
use App\User;


use Illuminate\Http\Request;
use Mail;

class EmailController extends Controller {
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
	 * @var ShipmentHeader
	 */
	private $user;

	/**
	 * @param OrderHeader $orderHeader
	 * @param InvoiceHeader $invoiceHeader
	 * @param ShipmentHeader $shipmentHeader
	 * @param User $user
	 */
	public function __construct(OrderHeader $orderHeader, InvoiceHeader $invoiceHeader, ShipmentHeader $shipmentHeader, User $user) {

		$this->orderHeader = $orderHeader;
		$this->invoiceHeader = $invoiceHeader;
		$this->shipmentHeader = $shipmentHeader;
		$this->user = $user;
	}

	public function placeOrder($orderHeaderId) {

		$data = $this->orderHeader->find($orderHeaderId);

		$view = 'emails.order';

		Mail::send($view, ['data' => $data], function ($m) use ($data) {

			$subject = 'ShopManila - Order success';

			$m->from('payment@shopmanila.com');

			$to = $data->customer->email;

			$m->to($to)->subject($subject);
		});

	}
	
	public function notifyAdminOfOrder($orderHeaderId) {

		$data = $this->orderHeader->find($orderHeaderId);

		$view = 'emails.order';

		Mail::send($view, ['data' => $data], function ($m) use ($data) {

			$subject = 'ShopManila - Order success';

			$m->from('payment@shopmanila.com');

			$to = \Config::get('constants.notifyEmailOrder');

			$m->to($to)->subject($subject);
		});

	}

	public function invoice($invoiceHeaderId) {

		$data = $this->invoiceHeader->find($invoiceHeaderId);

		$view = 'emails.invoice';

		Mail::send($view, ['data' => $data], function ($m) use ($data) {

			$subject = 'ShopManila - Invoice';

			$m->from('payment@shopmanila.com');

			$to = $data->orderHeader->customer->email;

			// $to = 'jfernando@thirtyonedigital.com';

			$m->to($to)->subject($subject);
		});

	}

	public function shipment($shipmentHeaderId) {

		$data = $this->shipmentHeader->find($shipmentHeaderId);

		$view = 'emails.shipment';

		Mail::send($view, ['data' => $data], function ($m) use ($data) {

			$subject = 'ShopManila - Shipment';

			$m->from('payment@shopmanila.com');

			$to = $data->orderHeader->customer->email;

			// $to = 'jfernando@thirtyonedigital.com';

			$m->to($to)->subject($subject);
		});

	}

	public function contact(Request $request)
	{

		$data = $request->all();

		$view = 'emails.contact';

		Mail::send($view, ['data' => $data], function ($m) use ($data) {

			$subject = 'ShopManila - Contact';

			$m->from('hello@app.com');

			$to = 'care@shopmanila.com';

			$m->to($to)->subject($subject);
		});
	}

	public function registerCustomer(){
		return view('emails.welcome');
	}

	public function emailMerchantInvoice(Request $request){

		$req = $request->all();
		$invoiceHeaderId = $req['invoiceHeaderId'];

		$data = $this->invoiceHeader->find($invoiceHeaderId);

		$view = 'emails.emailMerchantInvoice';

		Mail::send($view, ['data' => $data], function ($m) use ($data) {

			$subject = 'ShopManila Customer Invoice - Update';

			$m->from('admin@shopmanila.com');

			 $to = $this->getMerchantEmailInvoice($data->invoiceDetail);

			$m->to($to)->subject($subject);
		});
	}

	public function emailMerchantShipment(Request $request) {

		$req = $request->all();
		$shipmentHeaderId = $req['shipmentHeaderId'];

		$data = $this->shipmentHeader->find($shipmentHeaderId);

		$view = 'emails.emailMerchantShipment';

		Mail::send($view, ['data' => $data], function ($m) use ($data) {

			$subject = 'ShopManila Customer Shipment - Update';

			$m->from('admin@shopmanila.com');

			$to = $this->getMerchantEmailShipment($data->shipmentDetail);


			$m->to($to)->subject($subject);
		});

	}

	public function getMerchantEmailInvoice($data){

		foreach($data as $row){
			$storeId = $row->orderDetail->item->store_id;
		}
		return $this->user->whereStoreId($storeId)->pluck('email');
	}

	public function getMerchantEmailShipment($data){
		foreach($data as $row){
			$storeId = $row->orderDetail->item->store_id;
		}
		return $this->user->whereStoreId($storeId)->pluck('email');
	}





}
