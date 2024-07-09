<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateStoreRequest;
use Illuminate\Http\Request;

// use App\Http\Requests\CreateItemRequest;
use App\Store;
use Assets;
use Illuminate\Support\Facades\Auth;
use URL;
use JavaScript as Js;

class StoreController extends BaseController {

	protected $store;

	public function __construct(Store $store) {
		$this->store = $store;

		$this->executeMiddlewares();
	}

	public function executeMiddlewares() {

		if(! Auth::user()->get()->hasRole(['admin', 'manager'])){
			abort(404);
		}

//		$this->middleware('adminOnly');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$data = $this->store->orderBy('id', 'desc')->get();

		Assets::add([
			URL::asset('js/store/StoreListCtrl.js'),
			URL::asset('js/store/StoreSrvc.js'),
		]);

		return view('admin.stores.list', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		Assets::add([
			URL::asset('js/store/AddStoreCtrl.js'),
			URL::asset('js/store/StoreSrvc.js'),
			URL::asset('js/user/UserSrvc.js'),
		]);

		$ctrl = 'AddStoreCtrl';
		$title = 'Add';

		return view('admin.stores.form', compact('ctrl', 'title'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateStoreRequest $request
	 * @return Response
	 */
	public function store(CreateStoreRequest $request) {
		$data = $request->all();

		unset($data['errors']);
		unset($data['store_video']);

		$data['slug'] = $this->makeSlug($data['name'], 'App\Store');

		$r = $this->store->create($data);

		return ['id' => $r->id];
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id) {
		$store = $this->store->with('optionStatus')->find($id);

		return view('admin.stores.show', compact('store'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($id) {
		Assets::add([
			URL::asset('js/store/EditStoreCtrl.js'),
			URL::asset('js/store/StoreSrvc.js'),
		]);

		Js::put(['id' => $id]);

		$ctrl = 'EditStoreCtrl';
		$title = 'Edit';

		return view('admin.stores.form', compact('ctrl', 'title'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param CreateStoreRequest $request
	 * @param  int $id
	 * @return Response
	 */
	public function update(CreateStoreRequest $request, $id) {
		$data = $request->all();

		unset($data['errors']);
		unset($data['store_video']);

		$store = $this->store->find($id);

		$store->fill($data)
			->save();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id) {
		$this->store->destroy($id);
	}

	/**
	 * Retrieve single record
	 * @param  int $id
	 * @return object
	 */
	public function getRecord($id) {

		return $this->store->with('storeImage', 'storeLogo', 'storeVideo')->find($id);
	}

	public function getStores() {
		return $this->store->orderBy('name', 'desc')->get();
	}
}
