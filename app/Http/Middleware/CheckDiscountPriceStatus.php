<?php namespace App\Http\Middleware;

use Closure;
use App\Item;

class CheckDiscountPriceStatus {

	/**
	 * @var Item
	 */
	private $item;

	public function __construct(Item $item){

		$this->item = $item;
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

		$today = date('Y-m-d H:i:s');


		/*Mark all items as on sale if date setter is used*/
		$this->item
			->where('discounted_price_start_date', '<=', $today)
			->where('discounted_price_end_date', '>=', $today)
			->update(['on_sale' => 1]);

		/*
		 * Get all on sale items and check if their date setter is valid.
		 * If n, make on sale = 0
		*/

		$this->item->where('on_sale', 1)
			->where('discounted_price_end_date', '<=', $today)
			->update(['on_sale' => 0]);

		return $next($request);
	}

}
