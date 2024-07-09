<?php namespace App\Http\Controllers;

use App\Coupon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OptionCouponType;
use Illuminate\Http\Request;
use Assets;
use Illuminate\Support\Facades\URL;
use JavaScript as Js;

class AdminCouponController extends Controller {
	/**
	 * @var Coupon
	 */
	private $coupon;
	/**
	 * @var OptionCouponType
	 */
	private $optionCouponType;

	/**
	 * @param Coupon $coupon
	 * @param OptionCouponType $optionCouponType
	 */
	public function __construct(Coupon $coupon, OptionCouponType $optionCouponType){
		$this->coupon = $coupon;
		$this->optionCouponType = $optionCouponType;

		$this->executeMiddlewares();
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
			URL::asset('js/coupon/CouponListCtrl.js'),
			URL::asset('js/coupon/CouponSrvc.js'),
		]);

		$data = $this->coupon->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));

		return view('admin.coupons.list', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		Assets::add([
			URL::asset('js/coupon/AddCouponCtrl.js'),
			URL::asset('js/coupon/CouponSrvc.js'),
			URL::asset('js/store/StoreSrvc.js')
		]);

		$ctrl = 'AddCouponCtrl';
		$title = 'Add';

		return view('admin.coupons.form', compact('ctrl', 'title'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$data = $request->all();

		unset($data['errors']);

		if (isset($data['couponType'])) {
			$data['option_coupon_type_id'] = $data['couponType']['id'];
			unset($data['couponType']);
		}

		if (isset($data['store'])) {
			$data['store_id'] = $data['store']['id'];
			unset($data['store']);
		}

		$r = $this->coupon->create($data);

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
		$coupon = $this->coupon->find($id);

		return view('admin.coupons.display', compact('coupon'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		Assets::add([
			URL::asset('js/coupon/EditCouponCtrl.js'),
			URL::asset('js/coupon/CouponSrvc.js'),
			URL::asset('js/store/StoreSrvc.js')
		]);

		Js::put(['id' => $id]);

		$ctrl = 'EditCouponCtrl';
		$title = 'Edit';

		return view('admin.coupons.form', compact('ctrl', 'title'));
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

		$coupon = $this->coupon->find($id);

		unset($data['errors']);

		if (isset($data['couponType'])) {
			$data['option_coupon_type_id'] = $data['couponType']['id'];
			unset($data['couponType']);
		}

		//If for "All" stores, set store_id to null
		if (isset($data['store'])) {
			$data['store_id'] = $data['store']['id'];
			unset($data['store']);
		}else{
			$data['store_id'] = null;
			unset($data['store']);
		}


		$coupon->fill($data)
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
		$this->coupon->destroy($id);
	}

	/**
	 * Retrieve single record
	 * @param  int $id
	 * @return object
	 */
	public function getRecord($id)
	{
		return $this->coupon->find($id);
	}

	public function getCouponTypes() {
		return $this->optionCouponType->all();
	}

}
