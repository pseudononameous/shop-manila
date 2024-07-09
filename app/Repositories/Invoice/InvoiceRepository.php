<?php namespace App\Repositories\Invoice;

use App\Repositories\Invoice\Contracts\InvoiceInterface;
use Illuminate\Support\Facades\App;


class InvoiceRepository implements InvoiceInterface {

	private $invoiceHeader;
	private $orderDetail;
	private $invoiceDetail;

	public function __construct(){
		$this->invoiceHeader = App::make('App\InvoiceHeader');
		$this->orderDetail = App::make('App\OrderDetail');
		$this->invoiceDetail = App::make('App\InvoiceDetail');
	}

	/**
	 * Compute for total invoiced items of an order
	 * @param $orderDetail
	 * @param $invoiceDetailObj
	 * @param string $objPassed | if '', it will accept object from order header. Else if orderDetail, It will accept object from order details
	 * @return mixed
	 */
	public function computeSumInvoiceDetails($orderDetail, $invoiceDetailObj, $objPassed = '') {

		if(! $objPassed){
			foreach ($orderDetail as $key => $value) {
				$invoicedQty[ $value->id ] = $invoiceDetailObj->whereOrderDetailId($value->id)->sum('qty');
			}
		}else if ($objPassed == 'orderDetail'){

			$invoicedQty[$orderDetail->id] = $invoiceDetailObj->whereOrderDetailId($orderDetail->id)->sum('qty');

		}

		return $invoicedQty;
	}

	/**
	 * Compute for remaining qty to be invoiced
	 * @param $orderDetail
	 * @param $invoicedQty
	 * @param string $objPassed | if '', it will accept object from order header. Else if orderDetail, It will accept object from order details
	 * @return mixed
	 */
	public function computeQtyLeft($orderDetail, $invoicedQty, $objPassed = '') {

		if(! $objPassed) {
			foreach ($orderDetail as $key => $value) {
				$qtyLeft[ $value->id ] = $value->qty - $invoicedQty[ $value->id ];
			}
		}else if ($objPassed == 'orderDetail') {
			$qtyLeft[ $orderDetail->id ] = $orderDetail->qty - $invoicedQty[ $orderDetail->id ];
		}

		return $qtyLeft;
	}

	/**
	 * @param $orderDetail
	 * @param $qtyLeft
	 * @param string $objPassed | if '', it will accept object from order header. Else if orderDetail, It will accept object from order details
	 * @return array
	 */
	public function createInvoiceForm($orderDetail, $qtyLeft, $objPassed = '') {

		if(! $objPassed){

			foreach ($orderDetail as $key => $value) {

				$subtotal = $value->price * $qtyLeft[ $value->id ];

				$invoiceForm[] = [
					'id'       => $value->id,
					'name'     => $value->item->name . ' ' . $value->item->short_description,
					'price'    => $value->price,
					'subtotal' => $subtotal,
					'qty'      => $qtyLeft[ $value->id ],
				];
			}
		}else if ($objPassed == 'orderDetail') {


				$subtotal = $orderDetail->price * $qtyLeft[ $orderDetail->id ];

				$invoiceForm[] = [
					'id'       => $orderDetail->id,
					'name'     => $orderDetail->item->name . ' ' . $orderDetail->item->short_description,
					'price'    => $orderDetail->price,
					'subtotal' => $subtotal,
					'qty'      => $qtyLeft[ $orderDetail->id ],
				];

		}

		return $invoiceForm;
	}

	/**
	 * @param $qtyToInvoice
	 * @return int
	 */
	public function computeTotalQtyToInvoice($qtyToInvoice) {

		$qty = 0;

		foreach($qtyToInvoice as $value){
			$qty += $value;
		}

		return $qty;
	}

	public function computeTotalAmountToInvoice($orderDetails, $qtyToInvoice) {
		$totalAmount = 0;

		foreach ($orderDetails as $key => $value) {
			$qty = $qtyToInvoice[$value['id']];

			$totalAmount+= $qty * $value['price'];
		}


		return $totalAmount;
	}

	/**
	 * Check if order has been completely invoiced
	 * @param $orderHeaderId
	 * @return mixed
	 */
	public function isInvoiceComplete($orderHeaderId) {

		$isComplete = true;

		/*Get total qty of ordered items*/
		$orderDetails = $this->orderDetail->whereOrderHeaderId($orderHeaderId)->get();

		$orderedQty = 0;

		foreach ($orderDetails as $value) {
			$orderedQty+= $value['qty'];
		}

		/*Get total qty of invoiced items in an order*/
		$invoicedQty = $this->invoiceHeader->whereOrderHeaderId($orderHeaderId)->whereIsVoided(0)->sum('qty');

		if ($invoicedQty < $orderedQty) {
			$isComplete = false;
		}

		return $isComplete;

	}

	/**
	 * Check if order detail has been completely invoiced
	 * @param $orderDetailId
	 * @return mixed
	 */
	public function isOrderDetailInvoiceComplete($orderDetailId) {

		$isComplete = true;

		/*Get total qty of ordered items*/
		$orderDetails = $this->orderDetail->find($orderDetailId);

		$orderedQty = $orderDetails->qty;

		foreach ($orderDetails as $value) {
			$orderedQty += $value['qty'];
		}

		/*Get total qty of invoiced items in an order*/
		$invoicedQty = $this->invoiceDetail->whereOrderDetailId($orderDetailId)->sum('qty');

		if ($invoicedQty < $orderedQty) {
			$isComplete = false;
		}

		return $isComplete;

	}

	/**
	 * Check if order has been completely cancelled
	 * @param $orderHeaderId
	 * @return bool
	 */
	public function isInvoiceCancelled($orderHeaderId) {

		$isCancelled = false;

		/*Get total qty of ordered items*/
		$orderDetails = $this->orderDetail->whereOrderHeaderId($orderHeaderId)->get();

		$orderedQty = 0;

		foreach ($orderDetails as $value) {
			if($orderedQty == $value['qty']){
				$isCancelled = true;
			}
		}

		return $isCancelled;

	}

}