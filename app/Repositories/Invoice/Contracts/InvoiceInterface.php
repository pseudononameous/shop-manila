<?php namespace App\Repositories\Invoice\Contracts;

interface InvoiceInterface {

	public function computeSumInvoiceDetails($orderDetail, $shipmentDetailObj);
	public function computeQtyLeft($orderDetail, $invoiceQty);


}