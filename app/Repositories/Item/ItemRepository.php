<?php namespace App\Repositories\Item;

use App\Repositories\Item\Contracts\ItemInterface;
use Illuminate\Support\Facades\App;

class ItemRepository implements ItemInterface{

	private $item;

	public function __construct(){
		$this->item = App::make('App\Item');
		$this->store = App::make('App\Store');

		$this->itemCategory = App::make('App\ItemCategory');
		$this->categoryDetail = App::make('App\CategoryDetail');
	}


	/**
	 * Find the item's related item based on the related_item_code pattern
	 * @param $itemId
	 * @return mixed
	 */
	public function getItemVariation($itemId) {

		$i = $this->item->find($itemId);

		if (! $i->related_item_code)
			return [];

		$code = explode('-', $i->related_item_code);

		//Match first 2 segments of the related item code
//		$matchCode = $code[0] . '-' . $code [1];
		$matchCode = $code[0];

		return $this->item->where('related_item_code', 'LIKE', "$matchCode%")->take(4)->get();

	}

	public function createItemVariation($storeId, $sku) {

//		$s = $this->store->find($storeId);

//		$storeName = $s->name;

//		$matchCode = $storeName . '-' . $item;
		$matchCode = $sku;

		$relatedItemsCount = $this->item->where('related_item_code', 'LIKE', "$matchCode%")->count();

		$ctr = str_pad($relatedItemsCount, 4, '0', STR_PAD_LEFT);

		$relatedItemsCode = $matchCode . '-' . $ctr;

		return $relatedItemsCode;
	}

	public function getItemsWithSameCategory($itemId) {
//		$categoryDetailId = $this->itemCategory->whereItemId($itemId)->first()->pluck('category_detail_id');

		$categoryDetailId = 0;

		if ($i = $this->itemCategory->whereItemId($itemId)->first()){
			$categoryDetailId = $i->pluck('category_detail_id');
		}

		$items = $this->item->whereHas('itemCategory', function($q) use ($categoryDetailId)
		{
			$q->whereCategoryDetailId($categoryDetailId);

		})->orderByRaw("RAND()")->take(4)->get();

		// $randomItems = array_rand($items,4);


		return $items;
	}


	/** Get price. Check if it's on sale or under an event
	 * @param $item
	 * @param $itemEvent
	 * @return mixed
	 */
	public function getItemPrice($item, $itemEvent) {

		$price = $item->price;

		if ($item->on_sale) {
			$price = $item->discounted_price;
		}

		if (($item->event_id) && ($item->event->status)) {

			$price = $item->event_price;
		}

//		print_r($itemEvent);
		
		if($itemEvent){
			$price = $itemEvent['event_price'];
		}

		return $price;
	}

}