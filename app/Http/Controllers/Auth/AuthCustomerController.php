<?php namespace App\Http\Controllers\Auth;


use App\City;
use App\Repositories\Cart\Contracts\CartInterface;
use App\Repositories\Coupon\Contracts\CouponInterface;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Services\RegistrarCustomer as RegistrarCustomer;
use Cart as CartSession;
use Illuminate\Http\Request;

class AuthCustomerController extends Controller {

	protected $redirectPath = '/';
	protected $redirectTo = '/';
	protected $loginPath = '/authCustomer/login';
	/**
	 * @var CouponInterface
	 */
	private $couponInterface;
	/**
	 * @var CartInterface
	 */
	private $cartInterface;
	/**
	 * @var City
	 */
	private $city;

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param RegistrarCustomer|\Illuminate\Contracts\Auth\Registrar $registrar
	 * @param CouponInterface $couponInterface
	 * @param CartInterface $cartInterface
	 * @param City $city
	 */
	public function __construct(RegistrarCustomer $registrar, CouponInterface $couponInterface, CartInterface $cartInterface, City $city)
	{
		$this->auth = Auth::customer();
		$this->registrar = $registrar;

		$this->middleware('guestCustomer', ['except' => 'getLogout']);

		$this->couponInterface = $couponInterface;
		$this->cartInterface = $cartInterface;
		$this->city = $city;
	}

	/**
	 * Show the application registration form.
	 * @return \Illuminate\Http\Response
	 */
	public function getRegister()
	{
		$cities = $this->city->all();
		return view('auth.register', compact('cities'));
	}

	/**
	 * Handle a login request to the application.
	 * Merge session and database carts
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email', 'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			$this->cartInterface->mergeCarts();

			return redirect()->intended($this->redirectPath());
		}

		return redirect($this->loginPath())
			->withInput($request->only('email', 'remember'))
			->withErrors([
				'email' => $this->getFailedLoginMessage(),
			]);
	}
	/**
	 * Handle a registration request for the application.
	 * Merge session and database carts
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
		$validator = $this->registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$this->auth->login($this->registrar->create($request->all()));

		$this->cartInterface->mergeCarts();

		return redirect($this->redirectPath());
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogout()
	{
		$this->auth->logout();

		$this->couponInterface->disableCoupon();

		CartSession::instance('shopping')->destroy();

		return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
	}

}