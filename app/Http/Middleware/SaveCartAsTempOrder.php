<?php namespace App\Http\Middleware;

use App\Calculator;
use App\OrderDetailTemp;
use App\OrderHeaderTemp;
use App\Repositories\Cart\Contracts\CartInterface;
use App\Repositories\Coupon\Contracts\CouponInterface;
use Closure;
use Illuminate\Support\Facades\Auth;

class SaveCartAsTempOrder {
	/**
	 * @var Calculator
	 */
	private $calculator;
	/**
	 * @var OrderHeaderTemp
	 */
	private $orderHeaderTemp;
	/**
	 * @var OrderDetailTemp
	 */
	private $orderDetailTemp;
	/**
	 * @var CouponInterface
	 */
	private $couponInterface;


	/**
	 * @param CartInterface $cartInterface
	 * @param CouponInterface $couponInterface
	 * @param Calculator $calculator
	 * @param OrderHeaderTemp $orderHeaderTemp
	 * @param OrderDetailTemp $orderDetailTemp
	 */
	public function __construct(CartInterface $cartInterface, CouponInterface $couponInterface, Calculator $calculator, OrderHeaderTemp $orderHeaderTemp, OrderDetailTemp $orderDetailTemp){
		if (Auth::customer()->check()) {
			$this->cartInterface = $cartInterface;
			$this->customerId = Auth::customer()->get()->id;
		}

		$this->calculator = $calculator;
		$this->orderHeaderTemp = $orderHeaderTemp;
		$this->orderDetailTemp = $orderDetailTemp;
		$this->couponInterface = $couponInterface;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		$cart = $this->cartInterface->content();

		$discount = $this->couponInterface->getDiscount();

		$subtotal = $this->cartInterface->getSubtotal($cart);

		$grandTotal = $this->cartInterface->getGrandTotal();

		$orderHeaderTempId = $this->orderHeaderTemp->createHeader($this->customerId, $grandTotal, $subtotal, $discount);

		$this->orderDetailTemp->createDetails($orderHeaderTempId, $cart);

		return $next($request);
	}


}
