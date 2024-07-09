<?php
use App\CategoryDetail;
use App\CategoryHeader;
use App\City;
use App\Customer;
use App\Event;
use App\Module;
use App\OptionCouponType;
use App\OptionOrderStatus;
use App\OptionPayment;
use App\OptionShipping;
use App\OptionSize;
use App\OrderRecipient;
use App\Store;
use App\User;
use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;
use App\OptionStatus as OptionStatus;

class LookupTableSeeder extends Seeder {

	/**
	 *
	 */
	public function run()
	{

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');


//		DB::table('cities')->truncate();
//
//		City::create(['name' => 'Alaminos', 'with_cod' => 0]);
//		City::create(['name' => 'Amadeo', 'with_cod' => 1]);
//		City::create(['name' => 'Angeles', 'with_cod' => 0]);
//		City::create(['name' => 'Angono', 'with_cod' => 1]);
//		City::create(['name' => 'Antipolo', 'with_cod' => 1]);
//		City::create(['name' => 'Bacolod', 'with_cod' => 0]);
//		City::create(['name' => 'Bacoor', 'with_cod' => 1]);
//		City::create(['name' => 'Bago', 'with_cod' => 0]);
//		City::create(['name' => 'Baguio', 'with_cod' => 0]);
//		City::create(['name' => 'Bais', 'with_cod' => 0]);
//		City::create(['name' => 'Balanga', 'with_cod' => 0]);
//		City::create(['name' => 'Batac', 'with_cod' => 0]);
//		City::create(['name' => 'Batangas City', 'with_cod' => 1]);
//		City::create(['name' => 'Bayawan', 'with_cod' => 0]);
//		City::create(['name' => 'Baybay', 'with_cod' => 0]);
//		City::create(['name' => 'Bayugan', 'with_cod' => 0]);
//		City::create(['name' => 'Binangonan', 'with_cod' => 1]);
//		City::create(['name' => 'Biñan', 'with_cod' => 1]);
//		City::create(['name' => 'Bislig', 'with_cod' => 0]);
//		City::create(['name' => 'Bocaue', 'with_cod' => 1]);
//		City::create(['name' => 'Bogo', 'with_cod' => 0]);
//		City::create(['name' => 'Borongan', 'with_cod' => 0]);
//		City::create(['name' => 'Butuan', 'with_cod' => 0]);
//		City::create(['name' => 'Cabadbaran', 'with_cod' => 0]);
//		City::create(['name' => 'Cabanatuan', 'with_cod' => 0]);
//		City::create(['name' => 'Cabuyao', 'with_cod' => 1]);
//		City::create(['name' => 'Cadiz', 'with_cod' => 0]);
//		City::create(['name' => 'Cagayan de Oro', 'with_cod' => 0]);
//		City::create(['name' => 'Cainta', 'with_cod' => 1]);
//		City::create(['name' => 'Calamba', 'with_cod' => 1]);
//		City::create(['name' => 'Calapan', 'with_cod' => 0]);
//		City::create(['name' => 'Calbayog', 'with_cod' => 0]);
//		City::create(['name' => 'Caloocan', 'with_cod' => 1]);
//		City::create(['name' => 'Candon', 'with_cod' => 0]);
//		City::create(['name' => 'Canlaon', 'with_cod' => 0]);
//		City::create(['name' => 'Cardona', 'with_cod' => 1]);
//		City::create(['name' => 'Carcar', 'with_cod' => 0]);
//		City::create(['name' => 'Carmona', 'with_cod' => 1]);
//		City::create(['name' => 'Catbalogan', 'with_cod' => 0]);
//		City::create(['name' => 'Cauayan', 'with_cod' => 0]);
//		City::create(['name' => 'Cavite City', 'with_cod' => 1]);
//		City::create(['name' => 'Cebu City', 'with_cod' => 0]);
//		City::create(['name' => 'Cotabato City', 'with_cod' => 0]);
//		City::create(['name' => 'Dagupan', 'with_cod' => 0]);
//		City::create(['name' => 'Danao', 'with_cod' => 0]);
//		City::create(['name' => 'Dapitan', 'with_cod' => 0]);
//		City::create(['name' => 'Dasmariñas', 'with_cod' => 1]);
//		City::create(['name' => 'Davao City', 'with_cod' => 0]);
//		City::create(['name' => 'Digos', 'with_cod' => 0]);
//		City::create(['name' => 'Dipolog', 'with_cod' => 0]);
//		City::create(['name' => 'Dumaguete', 'with_cod' => 0]);
//		City::create(['name' => 'El Salvador', 'with_cod' => 0]);
//		City::create(['name' => 'Escalante', 'with_cod' => 0]);
//		City::create(['name' => 'GMA', 'with_cod' => 1]);
//		City::create(['name' => 'Gapan', 'with_cod' => 0]);
//		City::create(['name' => 'General Santos', 'with_cod' => 0]);
//		City::create(['name' => 'General Trias', 'with_cod' => 1]);
//		City::create(['name' => 'Gingoog', 'with_cod' => 0]);
//		City::create(['name' => 'Guiguinto', 'with_cod' => 1]);
//		City::create(['name' => 'Guihulngan', 'with_cod' => 0]);
//		City::create(['name' => 'Himamaylan', 'with_cod' => 0]);
//		City::create(['name' => 'Ilagan', 'with_cod' => 0]);
//		City::create(['name' => 'Iligan', 'with_cod' => 0]);
//		City::create(['name' => 'Iloilo City', 'with_cod' => 0]);
//		City::create(['name' => 'Imus', 'with_cod' => 1]);
//		City::create(['name' => 'Indang', 'with_cod' => 1]);
//		City::create(['name' => 'Iriga', 'with_cod' => 0]);
//		City::create(['name' => 'Isabela', 'with_cod' => 0]);
//		City::create(['name' => 'Jalajala', 'with_cod' => 1]);
//		City::create(['name' => 'Kabankalan', 'with_cod' => 0]);
//		City::create(['name' => 'Kidapawan', 'with_cod' => 0]);
//		City::create(['name' => 'Kawit', 'with_cod' => 1]);
//		City::create(['name' => 'Koronadal', 'with_cod' => 0]);
//		City::create(['name' => 'La Carlota', 'with_cod' => 0]);
//		City::create(['name' => 'Lamitan', 'with_cod' => 0]);
//		City::create(['name' => 'Laoag', 'with_cod' => 0]);
//		City::create(['name' => 'Lapu-Lapu', 'with_cod' => 0]);
//		City::create(['name' => 'Las Piñas', 'with_cod' => 1]);
//		City::create(['name' => 'Legazpi', 'with_cod' => 0]);
//		City::create(['name' => 'Ligao', 'with_cod' => 0]);
//		City::create(['name' => 'Lipa', 'with_cod' => 0]);
//		City::create(['name' => 'Lucena', 'with_cod' => 0]);
//		City::create(['name' => 'Maasin', 'with_cod' => 0]);
//		City::create(['name' => 'Mabalacat', 'with_cod' => 0]);
//		City::create(['name' => 'Makati', 'with_cod' => 1]);
//		City::create(['name' => 'Malabon', 'with_cod' => 1]);
//		City::create(['name' => 'Malaybalay', 'with_cod' => 0]);
//		City::create(['name' => 'Malolos', 'with_cod' => 1]);
//		City::create(['name' => 'Mandaluyong', 'with_cod' => 1]);
//		City::create(['name' => 'Mandaue', 'with_cod' => 0]);
//		City::create(['name' => 'Manila', 'with_cod' => 1]);
//		City::create(['name' => 'Marawi', 'with_cod' => 0]);
//		City::create(['name' => 'Marikina', 'with_cod' => 1]);
//		City::create(['name' => 'Marilao', 'with_cod' => 1]);
//		City::create(['name' => 'Masbate City', 'with_cod' => 0]);
//		City::create(['name' => 'Mati', 'with_cod' => 0]);
//		City::create(['name' => 'Mendez', 'with_cod' => 1]);
//		City::create(['name' => 'Meycauayan', 'with_cod' => 1]);
//		City::create(['name' => 'Muñoz', 'with_cod' => 0]);
//		City::create(['name' => 'Municipality of Pateros', 'with_cod' => 1]);
//		City::create(['name' => 'Muntinlupa', 'with_cod' => 1]);
//		City::create(['name' => 'Naga', 'with_cod' => 0]);
//		City::create(['name' => 'Naic', 'with_cod' => 1]);
//		City::create(['name' => 'Noveleta', 'with_cod' => 1]);
//		City::create(['name' => 'Navotas', 'with_cod' => 1]);
//		City::create(['name' => 'Olongapo', 'with_cod' => 0]);
//		City::create(['name' => 'Ormoc', 'with_cod' => 0]);
//		City::create(['name' => 'Oroquieta', 'with_cod' => 0]);
//		City::create(['name' => 'Ozamiz', 'with_cod' => 0]);
//		City::create(['name' => 'Pagadian', 'with_cod' => 0]);
//		City::create(['name' => 'Palayan', 'with_cod' => 0]);
//		City::create(['name' => 'Panabo', 'with_cod' => 0]);
//		City::create(['name' => 'Parañaque', 'with_cod' => 1]);
//		City::create(['name' => 'Pasay', 'with_cod' => 1]);
//		City::create(['name' => 'Pasig', 'with_cod' => 1]);
//		City::create(['name' => 'Passi', 'with_cod' => 0]);
//		City::create(['name' => 'Plaridel', 'with_cod' => 1]);
//		City::create(['name' => 'Puerto Princesa', 'with_cod' => 0]);
//		City::create(['name' => 'Quezon City', 'with_cod' => 1]);
//		City::create(['name' => 'Rodriguez', 'with_cod' => 0]);
//		City::create(['name' => 'Roxas', 'with_cod' => 0]);
//		City::create(['name' => 'Sagay', 'with_cod' => 0]);
//		City::create(['name' => 'Samal', 'with_cod' => 0]);
//		City::create(['name' => 'San Carlos', 'with_cod' => 0]);
//		City::create(['name' => 'San Fernando', 'with_cod' => 0]);
//		City::create(['name' => 'San Jose', 'with_cod' => 0]);
//		City::create(['name' => 'San Jose del Monte', 'with_cod' => 1]);
//		City::create(['name' => 'San Juan', 'with_cod' => 1]);
//		City::create(['name' => 'San Mateo', 'with_cod' => 1]);
//		City::create(['name' => 'San Pablo', 'with_cod' => 0]);
//		City::create(['name' => 'San Pedro', 'with_cod' => 1]);
//		City::create(['name' => 'Santa Maria', 'with_cod' => 1]);
//		City::create(['name' => 'Santa Rosa', 'with_cod' => 1]);
//		City::create(['name' => 'Santiago', 'with_cod' => 0]);
//		City::create(['name' => 'Silang', 'with_cod' => 1]);
//		City::create(['name' => 'Silay', 'with_cod' => 0]);
//		City::create(['name' => 'Sipalay', 'with_cod' => 0]);
//		City::create(['name' => 'Sorsogon City', 'with_cod' => 0]);
//		City::create(['name' => 'Surigao City', 'with_cod' => 0]);
//		City::create(['name' => 'Tabaco', 'with_cod' => 0]);
//		City::create(['name' => 'Tabuk', 'with_cod' => 0]);
//		City::create(['name' => 'Tacloban', 'with_cod' => 0]);
//		City::create(['name' => 'Tacurong', 'with_cod' => 0]);
//		City::create(['name' => 'Tagaytay', 'with_cod' => 0]);
//		City::create(['name' => 'Tagbilaran', 'with_cod' => 0]);
//		City::create(['name' => 'Taguig', 'with_cod' => 1]);
//		City::create(['name' => 'Tagum', 'with_cod' => 0]);
//		City::create(['name' => 'Talisay', 'with_cod' => 0]);
//		City::create(['name' => 'Tanauan', 'with_cod' => 0]);
//		City::create(['name' => 'Tanay', 'with_cod' => 1]);
//		City::create(['name' => 'Tandag', 'with_cod' => 0]);
//		City::create(['name' => 'Tangub', 'with_cod' => 0]);
//		City::create(['name' => 'Tanjay', 'with_cod' => 0]);
//		City::create(['name' => 'Tarlac City', 'with_cod' => 0]);
//		City::create(['name' => 'Tayabas', 'with_cod' => 0]);
//		City::create(['name' => 'Taytay', 'with_cod' => 1]);
//		City::create(['name' => 'Tanza', 'with_cod' => 1]);
//		City::create(['name' => 'Teresa', 'with_cod' => 1]);
//		City::create(['name' => 'Toledo', 'with_cod' => 0]);
//		City::create(['name' => 'Trece Martires', 'with_cod' => 1]);
//		City::create(['name' => 'Tuguegarao', 'with_cod' => 0]);
//		City::create(['name' => 'Urdaneta', 'with_cod' => 0]);
//		City::create(['name' => 'Valencia', 'with_cod' => 0]);
//		City::create(['name' => 'Valenzuela', 'with_cod' => 1]);
//		City::create(['name' => 'Victorias', 'with_cod' => 0]);
//		City::create(['name' => 'Vigan', 'with_cod' => 0]);
//		City::create(['name' => 'Zamboanga City', 'with_cod' => 0]);
//
//		DB::table('events')->truncate();
//		Event::create(['name' => 'Today\'s Deals', 'slug' => 'todays-deals', 'start_date' => '2016-04-23 16:00:00', 'end_date' => '2016-04-24 16:00:00', 'status' => 0]);
//
//		DB::table('option_shippings')->truncate();
//		OptionShipping::create(['name' => 'Xend', 'price' => 0.00]);
//		OptionShipping::create(['name' => 'LBC', 'price' => 0.00]);
////
//
//	    DB::table('option_coupon_types')->truncate();
//
//	    OptionCouponType::create(['name' => 'Fixed Price' ]);
//	    OptionCouponType::create(['name' => 'Percentage' ]);
//
//
//
//	    DB::table('option_statuses')->truncate();
//
//	    OptionStatus::create(['name' => 'Active' ]);
//	    OptionStatus::create(['name' => 'Inactive' ]);
//
//
//	    DB::table('stores')->truncate();
//
//	    Store::create(['name' => 'Nokia', 'slug' =>'nokia' ]);
//	    Store::create(['name' => 'Samsung', 'slug' => 'samsung' ]);
//
//	    DB::table('category_headers')->truncate();
//	    CategoryHeader::create(['id' => 1 ]);
//
//	    DB::table('category_details')->truncate();
//	    CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 0, 'name' => 'Men', 'slug' => 'men']); //1
//	    CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 0, 'name' => 'Women', 'slug' => 'women']); //2
//	    CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 0, 'name' => 'Kids', 'slug' => 'kids']);
//        CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 1, 'name' => 'Shoes', 'slug' => 'men-shoes']);
//        CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 1, 'name' => 'Clothes', 'slug' => 'men-clothes']);
//        CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 1, 'name' => 'Accessories', 'slug' => 'men-accessories']);
//        CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 2, 'name' => 'Shoes', 'slug' => 'women-shoes']);
//        CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 2, 'name' => 'Clothes', 'slug' => 'women-clothes']);
//        CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 2, 'name' => 'Accessories', 'slug' => 'women-accessories']);
//	    CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 3, 'name' => 'Shoes', 'slug' => 'kids-shoes']);
//        CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 3, 'name' => 'Clothes', 'slug' => 'kids-clothes']);
//        CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 3, 'name' => 'Accessories', 'slug' => 'kids-accessories']);

		//NEW CATEGORIES//

		//MAIN CATEGORIES//

//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 0, 'name' => 'Fashion', 'slug' => 'fashion']); //13
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 0, 'name' => 'Health & Beauty', 'slug' => 'health-and-beauty']); //14
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 0, 'name' => 'Travel', 'slug' => 'travel']);//15
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 0, 'name' => 'Electronics and Gadgets', 'slug' => 'electronics-and-gadgets']);//16
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 0, 'name' => 'Gifts', 'slug' => 'gifts']);//17
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 0, 'name' => 'Home & Living', 'slug' => 'home-and-living']);//18

		//SUB CATEGORIES

//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 13, 'name' => 'Apparel', 'slug' => 'apparel']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 13, 'name' => 'Bags', 'slug' => 'bags']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 13, 'name' => 'Watch', 'slug' => 'watch']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 13, 'name' => 'Eyewear', 'slug' => 'eyewear']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 13, 'name' => 'Jewelry', 'slug' => 'jewelry']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 13, 'name' => 'Shoes', 'slug' => 'shoes']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 13, 'name' => 'Socks', 'slug' => 'socks']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 13, 'name' => 'Undergarments', 'slug' => 'undergarments']);

//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 14, 'name' => 'Perfume', 'slug' => 'perfume']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 14, 'name' => 'Makeup', 'slug' => 'makeup']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 14, 'name' => 'Personal Care', 'slug' => 'personal-care']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 14, 'name' => 'Vitamins /Supplements', 'slug' => 'vitamins-supplements']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 14, 'name' => 'Skin', 'slug' => 'skin']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 14, 'name' => 'Hair', 'slug' => 'hair']);
//
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 15, 'name' => 'Luggages', 'slug' => 'luggages']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 15, 'name' => 'Travel Accessories', 'slug' => 'travel-accessories']);
//
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 16, 'name' => 'Camera & Accessories', 'slug' => 'camera-and-accessories']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 16, 'name' => 'Mobile &  Accessories', 'slug' => 'mobile-and-accessories']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 16, 'name' => 'Gaming Consoles', 'slug' => 'gaming-consoles']);
//
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 17, 'name' => 'Games', 'slug' => 'games']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 17, 'name' => 'Arts & Crafts', 'slug' => 'arts-and-crafts']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 17, 'name' => 'Souvenirs', 'slug' => 'souvenirs']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 17, 'name' => 'Toys', 'slug' => 'toys']);
//
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 18, 'name' => 'Kitchenware', 'slug' => 'kitchenware']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 18, 'name' => 'Storage', 'slug' => 'storage']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 18, 'name' => 'Home decor', 'slug' => 'home-decor']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 18, 'name' => 'Linens', 'slug' => 'linens']);
//		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 18, 'name' => 'Pets Care', 'slug' => 'pets-Care']);

		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 15, 'name' => 'Outdoor Items', 'slug' => 'outdoor-items']);
		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 14, 'name' => 'Fitness', 'slug' => 'fitness']);
		CategoryDetail::create(['category_header_id' => 1, 'parent_category_id' => 18, 'name' => 'Utility', 'slug' => 'utility']);

//		DB::table('option_payments')->truncate();
//		OptionPayment::create(['name' => 'Bank deposit']);
//		OptionPayment::create(['name' => 'Cash On Delivery (XEND Only)']);
//		OptionPayment::create(['name' => 'PayPal']);
//		OptionPayment::create(['name' => 'Payment Centers']);
//		OptionPayment::create(['name' => 'Dragonpay']);
//
//
//	    DB::table('users')->truncate();
//	    User::create([ 'name' => 'admin', 'email' => 'j@j.com', 'password' =>bcrypt('asdfasdf') ]);
//	    User::create(['store_id' => 2, 'name' => 'samsung', 'email' => 'samsung@s.com', 'password' =>bcrypt('asdfasdf') ]);
//	    User::create(['store_id' => 1, 'name' => 'nokia', 'email' => 'nokia@shopmanila.com', 'password' =>bcrypt('asdfasdf') ]);
//
//	    DB::table('order_recipients')->truncate();
//	    OrderRecipient::create(['name' => 'Reciever', 'email' => 'r@r.com', 'shipping_address' => 'Abc st.', 'mobile_number' => '0917 789 45 61']);
//
//	    DB::table('option_order_statuses')->truncate();
//	    OptionOrderStatus::create(['name' => 'Pending', 'code_name' => 'pending']);
//	    OptionOrderStatus::create(['name' => 'Processing', 'code_name' => 'processing']);
//	    OptionOrderStatus::create(['name' => 'Complete', 'code_name' => 'complete']);
//	    OptionOrderStatus::create(['name' => 'Cancelled', 'code_name' => 'cancelled']);
//	    OptionOrderStatus::create(['name' => 'Paid', 'code_name' => 'paid']);
//	    OptionOrderStatus::create(['name' => 'Verified', 'code_name' => 'verified']);
//	    OptionOrderStatus::create(['name' => 'Invoiced', 'code_name' => 'invoiced']);
//	    OptionOrderStatus::create(['name' => 'Accepted by Merchant', 'code_name' => 'accepted']);
//	    OptionOrderStatus::create(['name' => 'Rejected by Merchant', 'code_name' => 'rejected']);
//	    OptionOrderStatus::create(['name' => 'For Pickup', 'code_name' => 'pickup']);
//	    OptionOrderStatus::create(['name' => 'Shipped', 'code_name' => 'shipped']);
//	    OptionOrderStatus::create(['name' => 'Returned', 'code_name' => 'returned']);
//		OptionOrderStatus::create(['name' => 'Refund', 'code_name' => 'refund']);
//		OptionOrderStatus::create(['name' => 'Exchange', 'code_name' => 'exchange']);
//
//	    DB::table('permissions')->truncate();
////
////		/*Items module*/
//	    $createItem = new Permission();
//	    $createItem->name         = 'create-item';
//	    $createItem->display_name = 'Create Items'; // optional
//		$createItem->save();
//
//	    $readItem = new Permission();
//	    $readItem->name         = 'read-item';
//	    $readItem->display_name = 'Read Items'; // optional
//		$readItem->save();
//
//	    $updateItem = new Permission();
//	    $updateItem->name         = 'update-item';
//	    $updateItem->display_name = 'Update Items'; // optional
//		$updateItem->save();
//
//	    $deleteItem = new Permission();
//	    $deleteItem->name         = 'delete-item';
//	    $deleteItem->display_name = 'Delete Items'; // optional
//		$deleteItem->save();
////
////		/*Customers module*/
//	    $createCustomer = new Permission();
//	    $createCustomer->name         = 'create-customer';
//	    $createCustomer->display_name = 'Create Customers'; // optional
//		$createCustomer->save();
//
//	    $readCustomer = new Permission();
//	    $readCustomer->name         = 'read-customer';
//	    $readCustomer->display_name = 'Read Customers'; // optional
//		$readCustomer->save();
//
//	    $updateCustomer = new Permission();
//	    $updateCustomer->name         = 'update-customer';
//	    $updateCustomer->display_name = 'Update Customers'; // optional
//		$updateCustomer->save();
//
//	    $deleteCustomer = new Permission();
//	    $deleteCustomer->name         = 'delete-customer';
//	    $deleteCustomer->display_name = 'Delete Customers'; // optional
//		$deleteCustomer->save();
//
//		DB::table('roles')->truncate();
//
//		$admin = new Role();
//		$admin->name         = 'admin';
//		$admin->display_name = 'Shop manila admin'; // optional
//		$admin->description  = 'User is the admin of a given project'; // optional
//		$admin->save();
//
//		$merchant = new Role();
//		$merchant->name         = 'merchant';
//		$merchant->display_name = 'Merchants'; // optional
//		$merchant->description  = 'User is the admin of a store'; // optional
//		$merchant->save();
//
//
//		$manager = new Role();
//		$manager->name         = 'manager';
//		$manager->display_name = 'Manager'; // optional
//		$manager->description  = 'User is the manager of items and stores'; // optional
//		$manager->save();
//
//		DB::table('permission_role')->truncate();
//
//
//		/*Super admin permissions*/
//		$admin->attachPermission($createItem);
//		$admin->attachPermission($readItem);
//		$admin->attachPermission($updateItem);
//		$admin->attachPermission($deleteItem);
//
//		$admin->attachPermission($createCustomer);
//		$admin->attachPermission($readCustomer);
//		$admin->attachPermission($updateCustomer);
//		$admin->attachPermission($deleteCustomer);
//
//
////		/*Merchant permissions*/
//		$merchant->attachPermission($createItem);
//		$merchant->attachPermission($readItem);
//		$merchant->attachPermission($updateItem);
//		$merchant->attachPermission($deleteItem);
////
//////		/*Manager permissions*/
//		$manager->attachPermission($createItem);
//		$manager->attachPermission($readItem);
//		$manager->attachPermission($updateItem);
//		$manager->attachPermission($deleteItem);
//
//		DB::table('role_user')->truncate();
//
//		$user = User::where('email', 'j@j.com')->first();
//		$user->attachRole($admin);
//
//		$user = User::where('email', 'samsung@s.com')->first();
//		$user->attachRole($merchant);
//
//		$user = User::where('email', 'nokia@shopmanila.com')->first();
//		$user->attachRole($merchant);
//
//		DB::table('option_sizes')->truncate();
//		OptionSize::create(['name' => 'XS']);
//		OptionSize::create(['name' => 'S']);
//		OptionSize::create(['name' => 'M']);
//		OptionSize::create(['name' => 'L']);
//		OptionSize::create(['name' => 'XL']);
//		OptionSize::create(['name' => 'XXL']);
//		OptionSize::create(['name' => 'XXXL']);
//		OptionSize::create(['name' => 'N/A' ]);
//		OptionSize::create(['name' => '30' ]);
//		OptionSize::create(['name' => '31' ]);
//		OptionSize::create(['name' => '32' ]);
//	    OptionSize::create(['name' => '33' ]);
//		OptionSize::create(['name' => '34' ]);
//	    OptionSize::create(['name' => '35' ]);
//		OptionSize::create(['name' => '36' ]);
//		OptionSize::create(['name' => '37' ]);
//		OptionSize::create(['name' => '38' ]);
//		OptionSize::create(['name' => '39' ]);
//	    OptionSize::create(['name' => '40' ]);
//		OptionSize::create(['name' => '41' ]);
//		OptionSize::create(['name' => '42' ]);
//		OptionSize::create(['name' => '43' ]);
//		OptionSize::create(['name' => '44' ]);
//		OptionSize::create(['name' => '45' ]);
//		OptionSize::create(['name' => '46' ]);
//		OptionSize::create(['name' => 'FREE SIZE']);

		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}

}