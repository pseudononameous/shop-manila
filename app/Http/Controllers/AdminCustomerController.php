<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;

use App\Customer;
use App\CustomerType;

use App\Item;
use App\Wishlist;

use Assets;
use Illuminate\Support\Facades\DB;
use URL;
use JavaScript as Js;
use Auth;
use App\OrderHeader;


class AdminCustomerController extends Controller {

	protected $customer;

	public function __construct(Customer $customer)
	{
		$this->customer = $customer;

		if (Auth::customer()->check()){
			$this->customerId = Auth::customer()->get()->id;
		}

		//$this->executeMiddlewares();

	}

	public function executeMiddlewares() {
		$this->middleware('adminOnly');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Assets::add([
             URL::asset('js/customer/CustomerListCtrl.js'),
             URL::asset('js/customer/CustomerSrvc.js')
         ]);


		 $data = $this
		 		->customer
				->whereHas('orderHeader', function ($query)  {
					$query->where('option_order_status_id', '=', 3);
 				})
				->paginate(\Config::get('constants.paginationLimit'));
	//
 		$birthMonth = '';

	//


		return view('admin.customers.list', compact('data', 'birthMonth'));


 	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	// public function create()
	// {
 //        Assets::add([
 //            URL::asset('js/customer/AddCustomerCtrl.js'),
 //            URL::asset('js/customer/CustomerSrvc.js')
 //        ]);

	// 	$ctrl = 'AddCustomerCtrl';
	// 	$title = 'Add';

	// 	return view('admin.customer.form', compact('ctrl', 'title'));
	// }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	// public function store()
	// {
	// 	//
	// }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, OrderHeader $orderHeader, Wishlist $wishList, Item $item)
	{


		$customer = $this->customer->find($id);

		$orders = $orderHeader->whereCustomerId($id)->get();

		$wishes = $wishList->whereCustomerId($id)->get();

		return view('admin.customers.show', compact('customer','orders','wishes'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
//	public function edit($id)
//	{
//        Assets::add([
//            URL::asset('js/customer/EditCustomerCtrl.js'),
//            URL::asset('js/customer/CustomerSrvc.js')
//        ]);
//
//        Js::put(['id' => $id]);
//
//		$ctrl = 'EditCustomerCtrl';
//		$title = 'Edit';
//
//		return view('admin.customers.form', compact('ctrl', 'title'));
//	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{

		$data = $request->all();

		unset($data['errors']);

		$customer = $this->customer->find($id);

		$customer->fill($data)
			->save();

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->customer->destroy($id);
	}

	/**
	 * Retrieve single record
	 * @param  int $id
	 * @return object
	 */
	public function retrieveRecord($id)
	{
		return $this->customer->with('customerImage')->find($id);
	}


	/**
	 * Count total records
	 * @return int
	 */
	public function countRecords()
	{
		return $this->customer->count();
	}

	public function getTypes(CustomerType $customerType)
	{
		return $customerType->all();
	}


	public function getCustomers(Customer $customer)
	{
		return $customer->all();
	}

    public function changePassword(ChangePasswordRequest $request) {

		$data = $request->all();

		unset($data['errors']);

        $c = $this->customer->find($this->customerId);

        $c->password = \Hash::make($data['new_password']);

        $c->save();

        return;
    }

    /**
     * Assign 1 or 0 to fields
     * @param  Request $request
     * @return void
     */
    public function toggleConfidentiality(Request $request)
    {

    	$data = $request->all();

    	$field = $data['field'];

	 	$toggledValue = 1;

	 	$value = $this->customer->whereId($this->customerId)->pluck(''. $field .'');

	 	if($value){
	 		$toggledValue = 0;
	 	}

    	$update = [$field => $toggledValue];

    	$this->customer->whereId($this->customerId)->update($update);


    }


	public function search(Request $request) {



		Assets::add([
			URL::asset('js/customer/CustomerListCtrl.js'),
			URL::asset('js/customer/CustomerSrvc.js')
		]);

		$req = $request->all();
		$birthMonth = (isset($req['birthMonth'])) ? $req['birthMonth'] : '';
		$customerName = (isset($req['customerName'])) ? $req['customerName'] : '';
		$customerEmail = (isset($req['customerEmail'])) ? $req['customerEmail'] : '';
		$successfulOrder =  (isset($req['successfulOrder'])) ? $req['successfulOrder'] : '';
		$data = $this->customer->whereHas('orderHeader', function ($query)  {
			$query->where('option_order_status_id', '=', 3);
		})

			->searchBirthMonth($birthMonth)
			->searchCustomerName($customerName)
			->searchCustomerEmail($customerEmail)
			->orderBy('id', 'desc')
			->paginate(\Config::get('constants.paginationLimit'));
		return view('admin.customers.list', compact('data', 'birthMonth', 'customerName','successfulOrder'));

	}

}
