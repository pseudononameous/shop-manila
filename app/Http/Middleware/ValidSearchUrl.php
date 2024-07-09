<?php namespace App\Http\Middleware;

use Closure;

class ValidSearchUrl {

	/**
	 * Handle an incoming request.
	 * Check if q and sort params are available in the url
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		$query = $request->q;
		$sort = $request->sort;

		if ( (! $sort) || (! $query)){
			abort(404);
		}

		return $next($request);
	}

}
