<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OrderHeader;
use Illuminate\Http\Request;

/**
 * @property mixed merchantId
 * @property mixed merchantPassword
 * @property mixed environment
 */
class DragonpayController extends Controller {
	/**
	 * @var OrderHeader
	 */
	private $orderHeader;

	/**
	 * DragonpayController constructor.
	 * @param OrderHeader $orderHeader
	 */
	public function __construct(OrderHeader $orderHeader) {

		$this->merchantId = env('DRAGONPAY_MERCHANT_ID');
		$this->merchantPassword = env('DRAGONPAY_MERCHANT_PASSWORD');
		$this->environment = env('DRAGONPAY_ENV_LIVE');

		if($this->environment == 1){
			$this->url = 'https://gw.dragonpay.ph/Pay.aspx?';
		}else{
			$this->url = 'http://test.dragonpay.ph/Pay.aspx?';
			//$this->url = 'https://gw.dragonpay.ph/Pay.aspx?';
		}

		$this->orderHeader = $orderHeader;
	}

	public function createParameters($orderHeaderId) {


		$order = $this->orderHeader->find($orderHeaderId);

		$description = 'Ordered by ' . $order->customer->name;

		$parameters = [
			'merchantid'  => $this->merchantId,
			'txnid'       => $order->order_number,
			'amount'      => number_format($order->grand_total, 2, '.', ''),
			'ccy'         => 'PHP',
			'description' => $description,
			'email'       => $order->customer->email,
			'key' => $this->merchantPassword
		];

		return $parameters;
	}

	public function createDigestString($params) {

		$digestString = implode(':', $params);

		return $digestString;

	}

	public function doPayment(Request $request) {
		$orderHeaderId= $request->orderId;
		$params = $this->createParameters($orderHeaderId);
		$digestString = $this->createDigestString($params);

		unset($params['key']);

		$params['digest'] = sha1($digestString);

		$url =  $this->url . http_build_query($params, '', '&');

		header('Location: '. $url);
		exit;


	}

	/**
	 * @param Request $request
	 */
	public function verifyPayment(Request $request) {

		$data = $request->all();

		$txnId = $_POST['txnid'];

		$parameters = [
			'txnid'       => $_POST['txnid'],
			'refno'         => $_POST['refno'],
			'status'       => $_POST['status'],
			'message'       => $_POST['message'],
			'key' => env('DRAGONPAY_MERCHANT_PASSWORD')
		];

		$digestFromServer = $data['digest'];

		$digest = $this->createDigestString($parameters);

		if (sha1($digest) != $digestFromServer) {
			return 'result='. sha1($digest);
		}else{

			if ($_POST['status'] == 'S'){
				$o = $this->orderHeader->whereOrderNumber($txnId)->update(['option_order_status_id' => 5]);
			}

			return "result=OK";
		}



	}

}
