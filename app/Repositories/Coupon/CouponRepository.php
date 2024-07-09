<?php namespace App\Repositories\Coupon;

use App\Coupon;
use App\Repositories\Coupon\Contracts\CouponInterface;
use App\Repositories\Invoice\Contracts\InvoiceInterface;
use App\Repositories\Order\Contracts\OrderInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CouponRepository implements CouponInterface{
	/**
	 * @var Coupon
	 */
	private $coupon;


	public function __construct(){

		$this->coupon = App::make('App\Coupon');
		$this->couponCustomerUsage = App::make('App\CouponCustomerUsage');
		$this->optionCouponType = App::make('App\OptionCouponType');

		$this->customerId = 0;
		if (Auth::customer()->check()) {
			$this->customerId = Auth::customer()->get()->id;
		}

	}

	/**
	 * Get coupon from database
	 * @param $coupon
	 * @return array
	 */
	public function getCoupon($coupon) {

		$couponId = $this->coupon->whereCode($coupon)->pluck('id');

		$c = $this->coupon->find($couponId);

		if(! $c){
			return false;
		}

		$type = $c->optionCouponType->id;

		$coupon = ['couponId' => $couponId, 'discount' => $c->discount, 'type' => $type, 'code' => $c->code, 'storeIdWithDiscount' => $c->store_id];

		return $coupon;

	}

	/**
	 * returns couponId, discount and typeId
	 * @return mixed
	 */
	public function getActivatedCoupon() {
		return Session::get('coupon');
	}

	/**
	 * Store coupon {couponId, discount} to session
	 * @param $coupon
	 */
	public function useCoupon($coupon) {

		Session::put('coupon', $coupon);
	}


	/**
	 * Disable coupon in session
	 */
	public function disableCoupon() {
		Session::forget('coupon');
	}

//	public function getDiscount() {
//
//		$discount = 0;
//		$couponId = null;
//
//		if($coupon = Session::get('coupon')){
//			$coupon = $this->coupon->find($couponId);
//			$discount = $coupon->discount;
//		}
//
//		return $discount;
//	}


	/**
	 * Check if coupon data fetched from database meets minimum amount required
	 * @param $coupon {couponId, discount}
	 * @param $subtotal
	 * @return bool return false if not valid
	 */
	public function checkMinimumAmountRequired($coupon, $subtotal) {

		$response = false;

		$c = $this->coupon->find($coupon['couponId']);

		if($subtotal >= $c->minimum_cart_amount ){
			$response = true;
		}

		return $response;

	}

	/**
	 * Check if coupon exceeds max usage
	 * @param $coupon
	 * @return bool return false if it exceeds max usage
	 */
	public function checkCouponTotalUsage($coupon) {
		$response = false;

		$c = $this->coupon->find($coupon['couponId']);

		if($c->total_usage <= $c->uses_per_coupon){
			$response = true;
		}

		return $response;
	}

	/**
	 * Check if coupon exceeds max per customer usage
	 * @param $coupon
	 * @return bool return false if it exceeds max usage
	 */
	public function checkCouponPerCustomerUsage($coupon) {
		$response = false;

		$c = $this->coupon->find($coupon['couponId']);

		$ccu = $this->couponCustomerUsage
			->whereCouponId($coupon['couponId'])
			->whereCustomerId($this->customerId)
			->first();

		if(! $ccu){
			return $response = true;
		}

		if($ccu->usage <= $c->uses_per_customer){
			$response = true;
		}
		
		return $response;
	}

	public function getDiscount() {
		$discount = 0;

		if ($coupon = $this->getActivatedCoupon()) {
			$discount = $coupon['discount'];

		}

		return $discount;
	}

	public function getDiscountTypeId() {
		$discountTypeId = '';

		if ($coupon = $this->getActivatedCoupon()) {
			$discountTypeId = $coupon['type'];

		}

		return $discountTypeId;
	}

	/**
	 * @return string
	 */
	public function getDiscountType() {

		$discountType = '';

		if ($coupon = $this->getActivatedCoupon()) {
			$typeId = $coupon['type'];

			$d = $this->optionCouponType->find($typeId);

			$discountType = $d->name;
		}

		return $discountType;
	}

	public function getStoreWithDiscount() {
		$storeWithDiscount = '';

		if ($coupon = $this->getActivatedCoupon()) {
			$c = $this->coupon->find($coupon['couponId']);
			$storeWithDiscount = $c->store_id;
		}

		return $storeWithDiscount;
	}

	public function getAppliedCoupon() {

		$code = 'N/A';

		if ($coupon = $this->getActivatedCoupon()) {
			$c = $this->coupon->find($coupon['couponId']);
			$code = $c->code;
		}

		return $code;
	}

}
