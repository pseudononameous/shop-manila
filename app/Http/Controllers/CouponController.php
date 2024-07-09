<?php namespace App\Http\Controllers;

use App\Coupon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OptionCouponType;
use App\Repositories\Coupon\Contracts\CouponInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller {

	/**
	 * @var Coupon
	 */
	private $coupon;
	/**
	 * @var CouponInterface
	 */
	private $couponInterface;
	/**
	 * @var OptionCouponType
	 */
	private $optionCouponType;

	/**
	 * @param Coupon $coupon
	 * @param OptionCouponType $optionCouponType
	 * @param CouponInterface $couponInterface
	 * @internal param CouponCode $couponCode
	 */
	public function __construct(Coupon $coupon, OptionCouponType $optionCouponType, CouponInterface $couponInterface) {

		$this->coupon = $coupon;
		$this->couponInterface = $couponInterface;
		$this->optionCouponType = $optionCouponType;
	}


	/**
	 * Get coupon from session or database
	 * @param Request $request
	 * @return mixed
	 */
//	public function getCoupon(Request $request) {
//
//		$coupon = Session::get('coupon');
//
//		if (!$coupon) {
//
//			$data = $request->all();
//
//			$coupon = $this->coupon->whereCode($data['coupon'])->first();
//
//		}
//
//		return $coupon;
//
//
//	}

	/**
	 * Store coupon to session using coupon {string} if validations are passed
	 * @param Request $request
	 * @return array
	 */
	public function useCoupon(Request $request) {
		$data = $request->all();

		$response = ['response' => true];

		if(! $coupon = $this->couponInterface->getCoupon($data['coupon'])){

			return $response = ['response' => false];
		}

		if(! $this->couponInterface->checkMinimumAmountRequired($coupon, $data['subtotal'])){

			return $response = ['response' => false];
		}

		if(! $this->couponInterface->checkCouponTotalUsage($coupon)){

			return $response = ['response' => false];
		}

		if(! $this->couponInterface->checkCouponPerCustomerUsage($coupon)){
			return $response = ['response' => false];
		}

		$this->couponInterface->useCoupon($coupon);

		return $response;

//		$couponId = $this->coupon->whereCode($data['coupon'])->pluck('id');
//		$discount = $this->coupon->whereId($couponId)->pluck('discount');
//
//		$coupon = ['couponId' => $couponId, 'discount' => $discount];

//		Session::put('coupon', $coupon);

	}


	/**
	 * Remove coupon from session
	 */
	public function disableCoupon() {
		$this->couponInterface->disableCoupon();
	}

	public function getDiscount() {
		$discount = 0;

		if ($coupon = Session::get('coupon')) {
			$discount = $coupon['discount'];
		}

		return $discount;
	}

//	public function getAppliedCoupon() {
//
//		$code = 'N/A';
//
//		if ($coupon = $this->couponInterface->getActivatedCoupon()) {
//			$c = $this->coupon->find($coupon['couponId']);
//			$code = $c->code;
//		}
//
//		return $code;
//	}
}
