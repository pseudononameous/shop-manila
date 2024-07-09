<?php namespace App\Http\Middleware;

use App\Item;
use App\Store;
use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyIfOwnedItem {
	/**
	 * @var Item
	 */
	private $item;

	/**
	 * @param Store $store
	 * @param Item $item
	 */
	public function __construct(Store $store, Item $item) {
		$this->store = $store;
		$this->item = $item;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {

		if (Auth::user()->check()) {

			$userStoreId = Auth::user()->get()->store_id;

			$itemId = $request->items;

			$record = $this->item->find($itemId);

			if ($record) {

				if($userStoreId == null){
					return $next($request);
				}

				if ($userStoreId != $record->store_id) {
					return redirect('admin/items');
				}

			}


		}

		return $next($request);
	}

}
