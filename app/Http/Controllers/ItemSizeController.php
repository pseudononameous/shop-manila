<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ItemSize;
use App\OptionSize;
use Illuminate\Http\Request;

class ItemSizeController extends Controller {

	public function getSizes(OptionSize $optionSize) {
		return $optionSize->all();
	}

	public function saveItemSizes(Request $request, ItemSize $itemSize, $itemId) {

		$data = $request->all();

		 unset($data['errors']);

		$itemSize->whereItemId($itemId)->delete();

		foreach ($data['sizes'] as $key => $value) {
			if (isset($value['selected']) && ($value['selected'])) {

				$d = [
					'item_id'        => $itemId,
					'option_size_id' => $value['id'],
					'stock' => $data['stock'][$key]
				];

				$itemSize->create($d);
			}
		}
	}
}
