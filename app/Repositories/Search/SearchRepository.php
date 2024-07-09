<?php namespace App\Repositories\Search;

use App\Repositories\Search\Contracts\SearchInterface;
use Illuminate\Support\Facades\App;

class SearchRepository implements SearchInterface{
	private $item;

	public function __construct(){
	    $this->item = App::make('App\Item');
	}

	/**
	 * Search with mandatory sort
	 * @param $data
	 * @return mixed
	 */
	public function search($data) {

		$query = $data['q'];

		$sort = $data['sort'];

		$d = $this->searchByName($query)->orderBy($sort, 'asc');

		return $d;

	}

	/**
	 * Search table using name
	 * @param $query
	 * @return mixed
	 */
	public function searchByName($query) {

		return $this->item->where('name', 'LIKE', "%$query%");
	}


	/**
	 * Sort an eloquent collection
	 *
	 * @param $sortRequest
	 * @param $data
	 * @return mixed
	 */
	public function sortList($sortRequest, $data) {

		$sort = '';
		$order = 'asc';

		if (isset($sortRequest['sort'])) {
			$sort = $sortRequest['sort'];
		}

		/*Show for sale items only*/
		if(isset($sortRequest['sort']) && ($sortRequest['sort'] == 'sale_only')){
			return $data->whereOnSale(1)->orderBy('discounted_price', 'asc')->paginate(\Config('constants.itemsPerPage'));
		}

		if (! $sort){

			//return $data->orderByRaw("RAND()")->paginate(\Config('constants.itemsPerPage'));
			return $data->orderBy('name')->paginate(\Config('constants.itemsPerPage'));

		}else {

			if($sort == 'created_at'){
				$order = 'desc';
			}

			return $data->orderBy($sort, $order)->paginate(\Config('constants.itemsPerPage'));
		}
	}

}
