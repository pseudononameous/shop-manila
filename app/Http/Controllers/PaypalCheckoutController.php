<?php
namespace App\Http\Controllers;

use App\OrderDetail;
use App\OrderHeader;
use App\Repositories\Paypal\Contracts\PaypalInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Payment;


class PaypalCheckoutController extends Controller {
	private $_api_context;
	/**
	 * @var OrderHeader
	 */
	private $orderHeader;
	/**
	 * @var OrderDetail
	 */
	private $orderDetail;
	/**
	 * @var PaypalInterface
	 */
	private $paypalInterface;

	/**
	 * @param OrderHeader $orderHeader
	 * @param OrderDetail $orderDetail
	 * @param PaypalInterface $paypalInterface
	 */
	public function __construct(OrderHeader $orderHeader, OrderDetail $orderDetail, PaypalInterface $paypalInterface) {

		// $this->emailController = App::make('App\EmailController');

		$this->orderHeader = $orderHeader;
		$this->orderDetail = $orderDetail;
		$this->paypalInterface = $paypalInterface;

		// setup PayPal api context
		$paypalConf = Config::get('paypal');
		$this->_api_context = $this->paypalInterface->getApiContext($paypalConf);
		$this->_api_context->setConfig($paypalConf['settings']);
	}


	/**
	 * Set variables for payment in paypal checkout form
	 * @param $orderHeaderId
	 */
	public function postPayment($orderHeaderId) {

//		$orderHeaderId = $_POST['orderHeaderId'];
		$orderHeader = $this->orderHeader->find($orderHeaderId);



		//Send an email of orders to customer
		// $this->emailController->placeOrder($orderHeaderId);

		$payer = $this->paypalInterface->setPayer();

		$orderDetails = $this->orderDetail->whereOrderHeaderId($orderHeaderId)->get();
		$items = $this->paypalInterface->setItems($orderDetails);

		$itemList = $this->paypalInterface->setItemList($items);



		//Set amount details
		$subtotal = $orderHeader->subtotal;
        $shipping = $orderHeader->shipping_rate;
		$otherFees = $this->paypalInterface->setAmountDetails($subtotal, $shipping);

		//Set amount
		$grandTotal = $orderHeader->grand_total;
		$amount = $this->paypalInterface->setAmount($grandTotal, $otherFees);

		//Set transaction
		$transaction = $this->paypalInterface->setTransaction($itemList, $amount);

		//Set redirect url
		$redirectUrl = $this->paypalInterface->setRedirectUrls();

		//Set payment
		$payment = $this->paypalInterface->setPayment($payer, $redirectUrl, $transaction);

		try {
			$payment->create($this->_api_context);
		} catch (\PayPal\Exception\PPConnectionException $ex) {
			if (\Config::get('app.debug')) {
				echo "Exception: " . $ex->getMessage() . PHP_EOL;
				$err_data = json_decode($ex->getData(), true);
				exit;
			} else {

				die('Some error occur, sorry for inconvenient');
			}
		}


		foreach ($payment->getLinks() as $link) {
			if ($link->getRel() == 'approval_url') {
				$redirectUrl = $link->getHref();
				break;
			}
		}

		// add payment ID to session
		Session::put('paypal_payment_id', $payment->getId());

		// redirect to paypal
		if (isset($redirectUrl)) {
			return Redirect::away($redirectUrl);
		}

		return Redirect::route('paymentError')
			->with('error', 'Unknown error occurred');
	}

	public function getPaymentStatus() {
		// Get the payment ID before session clear
		$payment_id = Session::get('paypal_payment_id');

		// clear the session payment ID
		Session::forget('paypal_payment_id');

		$payerId = Input::get('PayerID');
		$token = Input::get('token');

		if (empty($payerId) || empty($token)) {
			return Redirect::to('/')
				->with('error', 'Payment failed');
		}

		$payment = Payment::get($payment_id, $this->_api_context);

		$execution = $this->paypalInterface->paymentExecution();

		//Execute the payment
		$result = $payment->execute($execution, $this->_api_context);

		/*Payment successful*/
		if ($result->getState() == 'approved') {

			return Redirect::to('success')
				->with('success', 'Payment success');
		}

		return Redirect::route('paymentError')
			->with('error', 'Payment failed');
	}

}