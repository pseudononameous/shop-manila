<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CreateUserRequest;

use Auth;
use Hash;
use Illuminate\Http\Request;

use App\User;


use Assets;
use URL;
use JavaScript as Js;

class UserController extends Controller {

	protected $user;
	private $userId;

	public function __construct(User $user) {
		$this->executeMiddlewares();

		if (Auth::check()) {
			$this->userId = Auth::user()->id;
		}
		$this->user = $user;
	}

	public function executeMiddlewares() {
		$this->middleware('adminOnly');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		Assets::add([
			URL::asset('js/user/UserListCtrl.js'),
			URL::asset('js/user/UserSrvc.js'),
			URL::asset('js/store/StoreSrvc.js'),
		]);


		$data = $this->user->paginate(\Config::get('constants.paginationLimit'));

		return view('admin.users.list', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		Assets::add([URL::asset('js/user/AddUserCtrl.js'), URL::asset('js/user/UserSrvc.js'),
			URL::asset('js/store/StoreSrvc.js'),
		]);

		$ctrl = 'AddUserCtrl';
		$title = 'Add';

		return view('admin.users.form', compact('ctrl', 'title'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateUserRequest $request
	 * @return Response
	 */
	public function store(CreateUserRequest $request) {

		$data = $request->all();

		unset($data['errors']);

		if (isset($data['store'])) {
			$data['store_id'] = $data['store']['id'];
			unset($data['store']);
		}

		$data['password'] = bcrypt($data['password']);

		$r = $this->user->create($data);

		return ['id' => $r->id];
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id) {

		$data = $this->user->find($id);

		return view('admin.users.show', compact('data'));


	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($id) {

		Assets::add([URL::asset('js/user/EditUserCtrl.js'),
			URL::asset('js/user/UserSrvc.js'),
			URL::asset('js/store/StoreSrvc.js'),
		]);

		Js::put(['id' => $id]);

		$ctrl = 'EditUserCtrl';
		$title = 'Edit';

		return view('admin.users.form', compact('ctrl', 'title'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param  int $id
	 * @return Response
	 */
	public function update(Request $request, $id) {

		$data = $request->all();

		unset($data['errors']);

		if (isset($data['store'])) {
			$data['store_id'] = $data['store']['id'];
			unset($data['store']);
		}

		$user = $this->user->find($id);
        $data['password'] = bcrypt($data['password']);
		$user->fill($data)
			->save();

		return ['id' => $id];
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id) {

		//$this->userLog->whereUserId($id)->delete();

		$this->user->destroy($id);

	}

	/**
	 * Retrieve single record
	 * @param  int $id
	 * @return object
	 */
	public function getRecord($id) {
		return $this->user->find($id);
	}

	/**
	 * Count total records
	 * @return int
	 */
	public function countRecords() {
		return $this->user->count();
	}

	/**
	 * @param Request $request
	 */
	public function attachRole(Request $request) {

		$data = $request->all();

		unset($data['errors']);

		$merchantRoleId = \Config::get('constants.merchantRoleId');

		$user = $this->user->find($data['userId']);

		$user->attachRole($merchantRoleId);

	}

	/**
	 * @param $userId
	 * @return mixed
	 */
	public function getAttachedRole($userId) {
		$roles = $this->user->find($userId)->roles;

		return $roles[0]->id;

	}

	public function removeAttachedRole($userId) {
		$userModel = $this->user->find($userId);
		$userModel->detachRoles($userModel->roles);
	}

	/**
	 * @param ChangePasswordRequest $request
	 */
	public function changePassword(ChangePasswordRequest $request) {

		$data = $request->all();

		unset($data['errors']);

		$c = $this->user->find($this->userId);

		$c->password = Hash::make($data['new_password']);

		$c->save();

		return;
	}
}
