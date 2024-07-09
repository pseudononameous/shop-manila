<?php
namespace App\Http\Middleware;

use Closure;
use App\Store;

class ValidStoreCategory
{
    
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
    public function handle($request, Closure $next) {
        
        $storeSlug = $request->storeSlug;
        $categorySlug = $request->categorySlug;
        
        $store = $this
            ->store
            ->whereSlug($storeSlug);
        
        $valid = $store
            ->whereHas('categoryHeader.categoryDetail', function ($q) use ($categorySlug) {
            $q->whereSlug($categorySlug);
        })->exists();
        
        if (! $valid) {
            return redirect('404');
        }
        
        return $next($request);
    }
}
