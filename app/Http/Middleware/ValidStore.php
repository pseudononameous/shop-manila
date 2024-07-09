<?php namespace App\Http\Middleware;

use Closure;
use App\Store;

class ValidStore {

	protected $store;
	public function __construct(Store $store)
	{
		$this->store = $store;
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

		$slug = $request->storeSlug;

		$valid = $this->store->active()->whereSlug($slug)->exists();


		if(! $valid){
			return redirect('404');
		}

		return $next($request);
	}

}
