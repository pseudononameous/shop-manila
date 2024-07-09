<?php namespace App\Http\Middleware;

use Closure;
use App\Store;

class ValidStoreItem {

    protected $store;
    public function __construct(Store $store) {
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

        $storeSlug = $request->storeSlug;
        $itemSlug = $request->itemSlug;
        
        $store = $this
            ->store
            ->where('slug', $storeSlug);
        
        $valid = $store
            ->whereHas('item', function ($q) use ($itemSlug) {
            $q->where('slug', $itemSlug);
        })->exists();
        
        if (! $valid) {
            return redirect('404');
        }

		return $next($request);
	}

}
