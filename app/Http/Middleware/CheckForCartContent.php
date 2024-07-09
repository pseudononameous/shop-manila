<?php namespace App\Http\Middleware;

use App\CartDetail;
use App\CartHeader;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckForCartContent {
	/**
	 * @var CartHeader
	 */
	private $cartHeader;
	/**
	 * @var CartDetail
	 */
	private $cartDetail;

	/**
	 * CheckForCartContent constructor.
	 * @param CartHeader $cartHeader
	 * @param CartDetail $cartDetail
	 */
	public function __construct(CartHeader $cartHeader, CartDetail $cartDetail){

		$this->cartHeader = $cartHeader;
		$this->cartDetail = $cartDetail;
	}

	/**
	 * Handle an incoming request.
	 * If customer doesn't have items in his cart, redirect to cart not to checkout
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$customerId = Auth::customer()->get()->id;

		$cartHeaderId = $this->cartHeader->whereCustomerId($customerId)->orderBy('id', 'desc')->pluck('id');

		$cartDetails = $this->cartDetail->whereCartHeaderId($cartHeaderId)->exists();

		if (! $cartDetails){
			return redirect('cart');
		}


		return $next($request);
	}

}
