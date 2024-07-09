<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\CategoryHeader;
use App\CategoryDetail;
use App\ItemCategory;

class ItemCategoryController extends Controller {


	public function getCategories(CategoryDetail $categoryDetail)
	{        
		//return $categoryDetail->orderBy('name','asc')->get();
		return $categoryDetail->orderBy('parent_category_id','asc')->get();
	}


	public function saveItemCategories(Request $request, ItemCategory $itemCategory, $itemId)
	{

		$data = $request->all();

		unset($data['errors']);

		$itemCategory->where('item_id', $itemId)->delete();

		foreach ($data as $key => $value) {
			if(isset($value['selected']) && ($value['selected'])){

				$d = [
					'category_detail_id' => $value['id'],
					'item_id' => $itemId
				];

				$itemCategory->create($d);
			}
		}
	}

}
