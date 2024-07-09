<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ItemSize;
use App\OptionPayment;
use App\OptionSize;
use Illuminate\Http\Request;

class LookupController extends Controller {


//	public function getItemSizes(OptionSize $optionSize) {
//		return $optionSize->all();
//		return $this->itemSize->with('OptionSize')->whereItemId($itemId)->get();
//	}

	public function getAssignedItemSize($itemId, ItemSize $itemSize) {
		return $itemSize->with('optionSize')
			->whereItemId($itemId)
			->where('stock', '!=', 0)
			->get();
	}

	public function getPaymentOptions(OptionPayment $optionPayment) {
		return $optionPayment->all();
	}

}
