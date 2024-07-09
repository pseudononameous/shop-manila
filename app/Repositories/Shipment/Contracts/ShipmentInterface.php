<?php namespace App\Repositories\Shipment\Contracts;

interface ShipmentInterface {

	public function computeSumShipmentDetails($orderDetail, $invoiceDetailObj);
	public function computeQtyLeft($orderDetail, $invoiceQty);


}