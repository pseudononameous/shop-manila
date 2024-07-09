<?php namespace App\Http\Middleware;

use App\Item;
use Closure;

class HideInactiveItem {
	/**
	 * @var Item
	 */
	private $item;

	/**
	 * HideInactiveItem constructor.
	 * @param Item $item
	 */
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

		$itemSlug = $request->itemSlug;

		$i = $this->item->whereSlug($itemSlug)->first();

		if($i['option_status_id'] == \Config::get('constants.inactive')){
			return redirect('/');
		}
		
		
		
		return $next($request);
	}

}
