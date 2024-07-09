<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

use Assets;

class WishlistController extends Controller {


	/**
	 * @var Wishlist
	 */
	private $wishlist;

	/**
	 * @param Wishlist $wishlist
	 */
	public function __construct(Wishlist $wishlist)
	{

		if(Auth::customer()->check()){
			$this->customerId = Auth::customer()->get()->id;
		}
		$this->wishlist = $wishlist;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Assets::add([URL::asset('js/wishlist/WishlistCtrl.js'),URL::asset('js/cart/CartSrvc.js'), URL::asset('js/wishlist/WishlistSrvc.js')]);

		$wishlist = $this->wishlist->whereCustomerId($this->customerId)->get();

		return view('public.account.wishlist', compact('wishlist'));
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
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request){
		$data = $request->all();

		unset($data['errors']);

		$data['customer_id'] = $this->customerId;

		if($this->wishlist->whereCustomerId($data['customer_id'])->whereItemId($data['item_id'])->first()){
			return;
		}

		$r = $this->wishlist->create($data);

		return ['id' => $r->id];
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
		$this->wishlist->destroy($id);
	}

}
