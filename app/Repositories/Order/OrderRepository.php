<?php namespace App\Repositories\Order;

use App\OrderDetail;
use App\OrderHeader;
use App\OrderRecipient;
use App\Repositories\Order\Contracts\OrderInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\ItemSize;

class OrderRepository implements OrderInterface {
	/**
	 * @var OrderRecipient
	 */
	private $orderRecipient;

	private $customerId;
	/**
	 * @var OrderHeader
	 */
	private $orderHeader;
	/**
	 * @var OrderDetail
	 */
	private $orderDetail;
	/**
	 * @var size
	 */
	private $size;
	private $item;
	private $orderDetailStatus;

	public function __construct() {

		if (Auth::customer()->check()) {
			$this->customerId = Auth::customer()->get()->id;
		}

		$this->orderRecipient = App::make('App\OrderRecipient');
		$this->orderHeader = App::make('App\OrderHeader');
		$this->orderDetail = App::make('App\OrderDetail');
		$this->size = App::make('App\ItemSize');
		$this->item = App::make('App\Item');
		$this->orderDetailStatus = App::make('App\OrderDetailStatus');
	}

	/**
	 * @param $data
	 * @return static
	 */
	public function createOrderRecipient($data) {


		if (isset($data['city'])) {
			$data['city_id'] = $data['city']['id'];

		} else {
			$data['city_id'] = null;
		}

		unset($data['city']);
		unset($data['billing_address']);
		unset($data['birthday']);

//		$orderRecipient = ['name' => $data['name'],
//		                   'email' => $data['email'],
//		                   'shipping_address' => $data['shipping_address'],
//		                   'telephone_number' => $data['telephone_number'],
//		                   'mobile_number' => $data['mobile_number'],
//						];

		return $this->orderRecipient->create($data);
	}

	/**
	 * @param $orderRecipientId
	 * @param $paymentOptionId
	 * @param $shippingOptionId
	 * @param $orderNumber
	 * @param $grandTotal
	 * @param $subtotal
	 * @param $discount
	 * @param $shippingRate
	 * @return static
	 */
	public function createOrderHeader($orderRecipientId, $paymentOptionId, $shippingOptionId, $orderNumber, $grandTotal, $subtotal, $discount, $shippingRate) {

		$orderHeader = [
			'customer_id'            => $this->customerId,
			'order_recipient_id'     => $orderRecipientId,
			'option_order_status_id' => \Config('constants.orderStatusPending'),
			'option_payment_id'      => $paymentOptionId,
			'option_shipping_id'     => $shippingOptionId,
			'order_number'           => $orderNumber,
			'grand_total'            => $grandTotal,
			'subtotal'               => $subtotal,
			'discount'               => $discount,
			'shipping_rate'          => $shippingRate,
		];

		return $this->orderHeader->create($orderHeader);
	}

	/**
	 * @param $orderHeaderId
	 * @param $orderDetailTemp
	 */
	public function createOrderDetails($orderHeaderId, $orderDetailTemp) {
		foreach ($orderDetailTemp as $value) {

			$data = [
				'order_header_id'        => $orderHeaderId,
				'item_id'                => $value['item_id'],
				'option_size_id'         => $value['option_size_id'],
				'qty'                    => $value['qty'],
				'price'                  => $value['price'],
				'subtotal'               => $value['subtotal'],
				'option_order_status_id' => \Config::get('constants.orderStatusPending'),
			];

			$this->orderDetail->create($data);
		}
	}


	/**
	 * Return ordered qty to item stock
	 * @param $orderHeaderId
	 */
	public function returnStock($orderHeaderId) {

		// Get order details of an order
		$orderDetail = $this->orderDetail->whereOrderHeaderId($orderHeaderId)
										->where("option_order_status_id", "<>", 4)
										 ->get();
		// 	echo '<pre>';
		// print_r($orderDetail); exit;

		foreach ($orderDetail as $od) {

			//Get qty of the ordered item with a specified size...

			$orderedQty = $od->qty;

			//Increment the item stock with the ordered qty
			$this->item->whereId($od->item_id)->increment('qty', $orderedQty);
			$this->size->whereItemId($od->item_id)->whereOptionSizeId($od->option_size_id)->increment('stock', $orderedQty);

//			$this->orderDetail->whereOrderHeaderId($orderHeaderId)->decrement('qty', $od->qty);
//			$stockReturn = $this->size->whereItemId($od->item_id)->whereOptionSizeId($od->option_size_id)->get();

//			foreach ($stockReturn as $s) {


//				$s->increment('stock', $od->qty);
//			}

		}

	}
	public function returnOrderStock($orderDetailId){

		$orderDetail = $this->orderDetail
		->whereId($orderDetailId)
		->where("option_order_status_id", "<>", 4)
		->first();

		$this->item->whereId($orderDetail->item_id)->increment('qty', $orderDetail->qty);
		$this->size->whereItemId($orderDetail->item_id)->whereOptionSizeId($orderDetail->option_size_id)->increment('stock', $orderDetail->qty);

	}




	/**
	 * @param $orderDetailId
	 * @param $statusId
	 * @return array
	 */
	public function saveOrderStatus($orderDetailId, $statusId) {

		$d = [
			'order_detail_id' => $orderDetailId,
			'option_order_status_id' => $statusId
		];

		$this->orderDetailStatus->create($d);

		return;

	}

	/**
	 * Mark order header as modified
	 * @param $orderDetailId
	 */
	public function markAsModified($orderDetailId) {

		//Get order header
		$orderHeaderId = $this->orderDetail->whereId($orderDetailId)->pluck('order_header_id');

		$r = $this->orderHeader->find($orderHeaderId);

		$r->is_modified = 1;

		$r->save();

	}

	/**
	 * Mark order header as NOT modified
	 * @param $orderHeaderId
	 */
	public function markAsNotModified($orderHeaderId) {

		$r = $this->orderHeader->find($orderHeaderId);

		$r->is_modified = 0;

		$r->save();
	}




}
