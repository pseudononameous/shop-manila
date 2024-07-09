<?php namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller {

	/**
	 * @var Customer
	 */
	private $customer;

	private $customerId;
	/**
	 * @param Customer $customer
	 */
	public function __construct(Customer $customer){

		$this->customer = $customer;

		if(Auth::customer()->check()){
			$this->customerId = Auth::customer()->get()->id;
		}

	}

	public function getCustomer() {
		return $this->customer->find($this->customerId);
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
	 * @param Request $request
	 * @param  int $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{

		$data = $request->all();

		unset($data['errors']);


		if (isset($data['city'])) {
			$data['city_id'] = $data['city']['id'];

		} else {
			$data['city_id'] = null;
		}

		unset($data['city']);

		$user = $this->customer->find($id);

		$user->fill($data)
			->save();

		return ['id' => $id];
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
