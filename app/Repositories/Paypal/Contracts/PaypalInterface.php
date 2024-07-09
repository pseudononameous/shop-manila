<?php namespace App\Repositories\Paypal\Contracts;

interface PaypalInterface {

	public function getApiContext($paypalConf);
	public function setPayer();
	public function setItems($orderDetails);
	public function setItemList($items);
	public function setAmountDetails($subtotal, $shipping);
	public function setAmount($grandTotal, $otherFees);
	public function setTransaction($items, $amount);
	public function setPayment($payer, $redirectUrl, $transaction);
	public function paymentExecution();
	public function setRedirectUrls();
}