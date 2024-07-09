<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\StoreVideo;

class StoreVideoController extends Controller {

	/**
	 * @param $storeId
	 * @param StoreVideo $storeVideo
	 * @param Request $request
	 */
	public function saveStoreVideos($storeId, StoreVideo $storeVideo, Request $request) {
		$data = $request->all();

		$storeVideo->whereStoreId($storeId)->delete();


		foreach ($data['video_link'] as $key => $video) {

			//If not null
			if($video){

				$d = ['store_id' => $storeId, 'video_link' => $video];

				$storeVideo->create($d);
			}

		}

	}

}
