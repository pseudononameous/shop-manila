<?php namespace App\Http\Controllers;

use App\Customer;
use App\Item;
use App\News;
use App\OrderDetail;
use App\OrderHeader;
use App\Store;
use App\User;
use App\ShipmentHeader;
use Assets;
use Illuminate\Support\Facades\Auth;
use URL;
use JavaScript as Js;

class AdminPagesController extends Controller {
	private $userId;
	private $userStoreId;
	/**
	 * @var User
	 */
	private $user;
	/**
	 * @var News
	 */
	private $news;
	/**
	 * @var OrderHeader
	 */
	private $orderHeader;
	/**
	 * @var OrderDetail
	 */
	private $orderDetail;

	/**
	 * @var ShipmentHeader
	 */
	private $shipmentHeader;

	/**
	 * Create a new controller instance.
	 * @param User $user
	 * @param News $news
	 * @param OrderHeader $orderHeader
	 * @param OrderDetail $orderDetail
	 * @param ShipmentHeader $shipmentHeader
	 */
	public function __construct(User $user, News $news, OrderHeader $orderHeader, OrderDetail $orderDetail, ShipmentHeader $shipmentHeader)
	{
		if(Auth::user()->check()){
			$this->userId = Auth::user()->get()->id;
			$this->userStoreId = $user->whereId($this->userId)->pluck('store_id');
		}

		$this->user = $user;
		$this->news = $news;
		$this->orderHeader = $orderHeader;
		$this->orderDetail = $orderDetail;
		$this->shipmentHeader = $shipmentHeader;
	}

	/**
	 * Landing page
	 */
	public function index()
	{
		return $this->dashboard();
	}


	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function dashboard()
	{
		$data = [];
		$data['orderPendingToday'] = $this->orderHeader->orderPendingToday()->count();
		$data['orderPendingYesterday'] =  $this->orderHeader->orderPendingYesterday()->count();
		$data['orderPendingOlder'] = $this->orderHeader->orderPendingOlder()->count();
		$data['allOrderToday'] = $this->orderHeader->allOrderToday()->count();
		$data['allOrderPastThirtyDays'] = $this->orderHeader->allOrderLastThirtyDays()->count();
		$data['allOrderShipments'] = $this->shipmentHeader->count();//count shipped orders
		$data['allOrderReturned'] =  $this->orderHeader->allOrderReturned()->count();
		$data['allOrderCancelled'] = $this->orderHeader->allOrderCancelled()->count();

		$orderState = $data;


		$news = $this->news->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));

		$showNews = true;
//		$showOrders = true;

		//Hide orders for null user store ids
//		if (! $this->userStoreId){
//			$showOrders = false;
//		}


		$latestOrders = $this->orderDetail->whereHas('item', function ($query) {
			$query->where('store_id', '=', $this->userStoreId);
		})->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));

		return view('admin.dashboard',compact('news', 'showNews', 'latestOrders', 'showOrders','orderState'));
	}

	public function changePassword() {

		return view('admin.changePassword');
	}

}
