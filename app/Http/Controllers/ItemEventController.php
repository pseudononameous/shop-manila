<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ItemEvent;
use Illuminate\Http\Request;

class ItemEventController extends Controller {

	public function saveItemEvents($itemId, ItemEvent $itemEvent, Request $request) {
		$data = $request->all();

		$itemEvent->whereItemId($itemId)->delete();

		if (isset($data['event'])) {

			foreach ($data['event'] as $key => $event) {

				if ($event) {

					$d = ['event_id' => $event['id'], 'item_id' => $itemId, 'event_price' => $data['price'][ $key ]];

					$itemEvent->create($d);
				}
			}
		}
	}

}
