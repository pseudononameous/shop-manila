<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ItemTag;
use Illuminate\Http\Request;

class TagController extends Controller {
	/**
	 * @var ItemTag
	 */
	private $itemTag;

	/**
	 * TagController constructor.
	 * @param ItemTag $itemTag
	 */
	public function __construct(ItemTag $itemTag){

		$this->itemTag = $itemTag;
	}

	public function saveItemTags(Request $request) {
		
		$data = $request->all();

		$this->itemTag->whereItemId($data['itemId'])->delete();

		foreach ($data['tags'] as $value){

			$tag = ['item_id' => $data['itemId'], 'name' => $value['text']];

			$this->itemTag->create($tag);
		}

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
