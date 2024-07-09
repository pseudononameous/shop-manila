<?php namespace App\Repositories\Shipment;

use App\Repositories\Shipment\Contracts\ShipmentInterface;
use Illuminate\Support\Facades\App;

class ShipmentRepository implements ShipmentInterface {

	private $shipmentHeader;
	private $orderDetail;

	public function __construct() {
		$this->shipmentHeader = App::make('App\ShipmentHeader');
		$this->orderDetail = App::make('App\OrderDetail');
	}

	/**
	 * Compute for total shipped items of an order
	 * @param $orderDetail
	 * @param $invoiceDetailObj
	 * @param string $objPassed | if '', it will accept object from order header. Else if orderDetail, It will accept object from order details
	 * @return mixed
	 */
	public function computeSumShipmentDetails($orderDetail, $invoiceDetailObj, $objPassed = '') {

		if (!$objPassed) {

			foreach ($orderDetail as $key => $value) {
				$invoicedQty[ $value->id ] = $invoiceDetailObj->whereOrderDetailId($value->id)->sum('qty');
			}

		} else if ($objPassed == 'orderDetail') {
			$invoicedQty[ $orderDetail->id ] = $invoiceDetailObj->whereOrderDetailId($orderDetail->id)->sum('qty');
		}

		return $invoicedQty;
	}

	/**
	 * Compute for remaining qty to be shipped
	 * @param $orderDetail
	 * @param $invoicedQty
	 * @param string $objPassed | if '', it will accept object from order header. Else if orderDetail, It will accept object from order details
	 * @return mixed
	 */
	public function computeQtyLeft($orderDetail, $invoicedQty, $objPassed = '') {

		if (!$objPassed) {

			foreach ($orderDetail as $key => $value) {
				$qtyLeft[ $value->id ] = $value->qty - $invoicedQty[ $value->id ];
			}

		} else if ($objPassed == 'orderDetail') {
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
	public function createShipmentForm($orderDetail, $qtyLeft, $objPassed = '') {


		if (!$objPassed) {
			foreach ($orderDetail as $key => $value) {

				$shipmentForm[] = [
					'id'   => $value->id,
					'name' => $value->item->name . ' ' . $value->item->short_description,
					'qty'  => $qtyLeft[ $value->id ],
				];
			}
		} else if ($objPassed == 'orderDetail') {
			$shipmentForm[] = [
				'id'   => $orderDetail->id,
				'name' => $orderDetail->item->name . ' ' . $orderDetail->item->short_description,
				'qty'  => $qtyLeft[ $orderDetail->id ],
			];
		}


		return $shipmentForm;
	}

	/**
	 * @param $qtyToShip
	 * @return int
	 */
	public function computeTotalQtyToShip($qtyToShip) {

		$qty = 0;

		foreach ($qtyToShip as $value) {
			$qty += $value;
		}

		return $qty;
	}

	/**
	 * Check if order has been completely shipped
	 * @param $orderHeaderId
	 * @return bool
	 */
	public function isShipmentComplete($orderHeaderId) {

		$isComplete = true;

		/*Get total qty of ordered items*/
		$orderDetails = $this->orderDetail->whereOrderHeaderId($orderHeaderId)->get();

		$orderedQty = 0;

		foreach ($orderDetails as $value) {
			$orderedQty += $value['qty'];
		}

		/*Get total qty of shipped items in an order*/
		$shippedQty = $this->shipmentHeader->whereOrderHeaderId($orderHeaderId)->sum('qty');

		if ($shippedQty < $orderedQty) {
			$isComplete = false;
		}

		return $isComplete;

	}

	/**
	 * Check if order has been completely cancelled
	 * @param $orderHeaderId
	 * @return bool
	 */
	public function isShipmentCancelled($orderHeaderId) {

		$isCancelled = false;

		/*Get total qty of ordered items*/
		$orderDetails = $this->orderDetail->whereOrderHeaderId($orderHeaderId)->get();

		$orderedQty = 0;

		foreach ($orderDetails as $value) {
			if ($orderedQty == $value['qty']) {
				$isCancelled = true;
			}
		}

		return $isCancelled;

	}

}