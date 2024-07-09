<?php namespace App\Http\Controllers;


use App\Http\Requests;

use App\Http\Controllers\Controller;


use App\Item;

use App\ItemTag;
use App\Store;

use App\Repositories\Search\Contracts\SearchInterface;

use Illuminate\Http\Request;


class SearchController extends Controller {


	/**
	 * @param Request $request
	 * @param Item $item
	 * @param ItemTag $itemTag
	 * @return \Illuminate\View\View|void
	 * @internal param Store $store
	 * @internal param SearchInterface $searchInterface
	 */

	public function search(Request $request, Item $item, ItemTag $itemTag) {

		$req = $request->all();

		$sort = $req['sort'];


		if (isset($req['q'])) {

			$query = $req['q'];

			$searchValue = $req['q'];
			$searchSubstr = substr($searchValue, 0, 4);



			$status = $item->where('option_status_id', '=', 1);


			//
			// $retrieve_items = $item
			// 	->whereHas('optionStatus', function ($q) {
			// 		$q->where('id', 1);
			// 	})
			// 	->WhereHas('store', function ($q){
			// 		$q->where('option_status_id',1);
			// 	})
			// 	->select('name')
			// 	->groupby('name')
			// 	->get();
			//

			$items = $item
				->where('name', 'LIKE', "%$searchValue%")
		  			->whereHas('optionStatus', function ($q) {
			      		$q->where('id', 1);
	   		  	})

				->orwhere('name', 'LIKE', "%$searchSubstr%")
					->whereHas('optionStatus', function ($q) {
						$q->where('id', 1);
				})

	   		  	->whereHas('store', function ($q) {
					$q->where('option_status_id',1);
				})

				->orWhereHas('store', function ($query) use ($searchValue) {
					$query->where('name', 'LIKE', "%$searchValue%")
	  		    		  ->where('option_status_id', 1);
			  	})

				->orWhereHas('itemTag', function ($q) use ($searchValue, $itemTag) {
					$q->where('name', 'LIKE', "%$searchValue%");
				})

				->active()
				->groupBy('id')
				->orderBy($sort, 'asc')
				->paginate(\Config::get('constants.paginationLimit'));

				$result = 1;

				if($items->count() == 0){

					$itemStatus = $item
						->where('option_status_id',1)
						->select('id')
						->whereHas('store', function ($q) {
							$q->where('option_status_id',1);
						})
						->limit(4)
						->orderByRaw("RAND()")->get();

				    $recomendedItems = $itemStatus->implode('id',',');

					$recomendedItems = preg_split("/[,]/", $recomendedItems);

					$items = $item
						->wherein('id', $recomendedItems)
						->whereHas('optionStatus', function ($q) {
							$q->where('id', '=', 1);
		   				})
						->active()
						->groupBy('id')
						->orderBy($sort, 'asc')
						->paginate(\Config::get('constants.paginationLimit'));

					$result = 0;
				}


			}


		return view('public.search', compact('status', 'items', 'query', 'sort', 'result'));


	}


}
