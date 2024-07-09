<?php namespace App\Http\ViewComposers;

use App\Event;
use Illuminate\Contracts\View\View;
use App\CategoryDetail;


use Auth;
use Cart as CartSession;
use App\CartHeader;
use App\CartDetail;

class CategoryComposer {


	protected $cd;
	/**
	 * @var Event
	 */
	private $event;

	/**
	 * CategoryComposer constructor.
	 * @param CategoryDetail $cd
	 * @param Event $event
	 */
	public function __construct(CategoryDetail $cd, Event $event) {
		$this->cd = $cd;
		$this->event = $event;
	}


	public function compose(View $view) {





		$menCategory = $this->cd->whereParentCategoryId(\Config('constants.menCategoryId'))->get();
		$womenCategory = $this->cd->whereParentCategoryId(\Config('constants.womenCategoryId'))->get();
		$kidsCategory = $this->cd->whereParentCategoryId(\Config('constants.kidsCategoryId'))->get();
		$fashionCategory = $this->cd->whereParentCategoryId(\Config('constants.fashionCategoryId'))->get();
		$healthCategory = $this->cd->whereParentCategoryId(\Config('constants.healthCategoryId'))->get();
		$travelCategory = $this->cd->whereParentCategoryId(\Config('constants.travelCategoryId'))->get();
		$electronicsCategory = $this->cd->whereParentCategoryId(\Config('constants.electronicsCategoryId'))->get();
		$homeCategory = $this->cd->whereParentCategoryId(\Config('constants.homeCategoryId'))->get();
		$giftsCategory = $this->cd->whereParentCategoryId(\Config('constants.giftsCategoryId'))->get();

		$event = $this->event->get();

		foreach ($event as $e) {
			if ($e->status == 0) {
				$event = [];
			}
		}

		$view->with('menCategory', $menCategory);
		$view->with('womenCategory', $womenCategory);
		$view->with('kidsCategory', $kidsCategory);
		$view->with('fashionCategory', $fashionCategory);
		$view->with('healthCategory', $healthCategory);
		$view->with('travelCategory', $travelCategory);
		$view->with('electronicsCategory', $electronicsCategory);
		$view->with('giftsCategory', $giftsCategory);
		$view->with('homeCategory', $homeCategory);
		$view->with('event', $event);





		#Count the number of items in cart
		$cart = 0;
		$cart = CartSession::instance('shopping')->content()->count();
	    $view->with('numITEMS', $cart);
		if(Auth::customer()->check()){

			$customerID =  Auth::customer()->get()->id;

			$cartHeader = CartHeader::where('customer_id', $customerID);

			if($cartHeader->count()){

			   $cartHeaderTBL = $cartHeader->first(); 												//getCartHeader Customer_id
			   $cartHeaderID = $cartHeaderTBL->id;													//getCartHeader Customer_id
			   $cartDetailTBL = CartDetail::where('cart_header_id', $cartHeaderID)->count(); 		//count number of items on cart by cart_header_id
			   $view->with('numITEMS', $cartDetailTBL);

			}

		}
		#end count the number of items in cart





	}




}
