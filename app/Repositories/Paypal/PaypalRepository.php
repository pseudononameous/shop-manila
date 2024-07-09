<?php namespace App\Repositories\Paypal;

use App\Repositories\Paypal\Contracts\PaypalInterface;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class PaypalRepository implements PaypalInterface{

	private $item;

	public function __construct(){
		$this->item = App::make('App\Item');
		$this->store = App::make('App\Store');

		$this->itemCategory = App::make('App\ItemCategory');
		$this->categoryDetail = App::make('App\CategoryDetail');
	}

	public function getApiContext($paypalConf) {
		$apiContext = new ApiContext(new OAuthTokenCredential($paypalConf['client_id'], $paypalConf['secret']));
		return $apiContext;
	}

	public function setPayer(){
		$payer = new Payer();
		$payer->setPaymentMethod('paypal');
		return $payer;
	}

	/**
	 * Create items for paypal using order details
	 * @param $orderDetails
	 * @return array
	 */
	public function setItems($orderDetails){

		foreach ($orderDetails as $value) {
			$item = new Item();

			$item->setName($value['item']['name'])
				->setCurrency('PHP')
				->setQuantity($value['qty'])
				->setPrice($value['price']);

			$items[] = $item;
		}

		return $items;
	}

	/**
	 * Set items as list
	 * @param $items
	 * @return ItemList
	 */
	public function setItemList($items){
		$itemList = new ItemList();
		$itemList->setItems($items);
		return $itemList;
	}

	/**
	 * Set other fees
	 * @param $subtotal
	 * @param $shipping
	 * @return Details
	 */
	public function setAmountDetails($subtotal, $shipping){
		$amountDetails = new Details();
		$amountDetails->setSubtotal($subtotal);
		$amountDetails->setTax('0');
		$amountDetails->setShipping($shipping);
		return $amountDetails;
	}

	/**
	 * Set amount to be payed
	 * @param $grandTotal
	 * @param $otherFees
	 * @return Amount
	 */
	public function setAmount($grandTotal, $otherFees){
		$amount = new Amount();
		$amount->setCurrency('PHP')
			->setTotal($grandTotal)
			->setDetails($otherFees);

		return $amount;
	}

	/**
	 * @param $items
	 * @param $amount
	 * @return Transaction
	 */
	public function setTransaction($items, $amount){
		$transaction = new Transaction();
		$transaction->setAmount($amount)
			->setItemList($items)
			->setDescription('Your transaction description');

		return $transaction;
	}

	/**
	 * @param $payer
	 * @param $redirectUrl
	 * @param $transaction
	 * @return Payment
	 */
	public function setPayment($payer, $redirectUrl, $transaction){
		$payment = new Payment();
		$payment->setIntent('Sale')
			->setPayer($payer)
			->setRedirectUrls($redirectUrl)
			->setTransactions(array($transaction));

		return $payment;
	}

	/**
	 * @return PaymentExecution
	 */
	public function paymentExecution(){
		$execution = new PaymentExecution();
		$execution->setPayerId(Input::get('PayerID'));

		return $execution;
	}

	/**
	 * @return RedirectUrls
	 */
	public function setRedirectUrls(){
		$redirectUrl = new RedirectUrls();
		$redirectUrl->setReturnUrl(URL::route('payment.status'))
			->setCancelUrl(URL::route('payment.status'));
		return $redirectUrl;
	}

}