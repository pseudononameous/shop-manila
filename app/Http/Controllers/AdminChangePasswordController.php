<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AdminChangePasswordController extends Controller {

	/**
	 * @var User
	 */
	private $user;

	/**
	 * @param User $user
	 * @internal param Customer $customer
	 */
	public function __construct(User $user){

		if(Auth::user()->check()){
			$this->userId = Auth::user()->get()->id;
		}

		$this->user = $user;
	}

	/**
	 * @param ChangePasswordRequest $changePasswordRequest
	 * @return array
	 * @internal param $id
	 */
	public function executeChangePassword(ChangePasswordRequest $changePasswordRequest) {
		$data = $changePasswordRequest->all();

		$c = $this->user->find($this->userId);
		$hashedPassword = $c->password;

		if (! Hash::check($data['old_password'], $hashedPassword)) {
			return Redirect::back()->withErrors(['The old password you entered is incorrect.']);
		}

		unset($data['errors']);

		$newPassword = Hash::make($data['password']);
		$update = ['password' => $newPassword];

		$c->fill($update)
			->save();

		\Session::flash('message','You have successfully changed your password!');

		return Redirect::back();
	}
}
