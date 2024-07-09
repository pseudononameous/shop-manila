<?php namespace App\Repositories\Order\Contracts;

interface OrderInterface {

	public function createOrderRecipient($data);
	public function createOrderHeader($orderRecipientId, $paymentOptionId, $shippingOptionId, $orderNumber, $grandTotal, $subtotal, $discount, $shippingRate);
	public function createOrderDetails($orderHeaderId, $orderDetailTemp);

}