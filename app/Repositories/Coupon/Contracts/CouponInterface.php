<?php namespace App\Repositories\Coupon\Contracts;

interface CouponInterface {

	public function getCoupon($coupon);
	public function useCoupon($coupon);
	public function getActivatedCoupon();
	public function disableCoupon();
	public function checkMinimumAmountRequired($data, $grandTotal);
	public function checkCouponTotalUsage($coupon);
	public function checkCouponPerCustomerUsage($coupon);
	public function getDiscountType();
	public function getAppliedCoupon();


}