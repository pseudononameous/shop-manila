<?php namespace App\Services;

use App\Customer;
use Illuminate\Support\Facades\Mail;
use Validator;
use MCAPI;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class RegistrarCustomer implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data) {
		return Validator::make($data, [
			'name'             => 'required|max:255',
			'email'            => 'required|email|max:255|unique:customers',
			'password'         => 'required|confirmed|min:6',
			'billing_address'  => 'required',
			'shipping_address' => 'required',
//			'telephone_number' => 'required',
			'mobile_number'    => 'required',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 * @return User
	 */
	public function create(array $data) {

		if (!isset($data['city_id'])) {
			$data['city_id'] = null;
		}

		$customer = Customer::create([
			'city_id'          => $data['city_id'],
			'name'             => $data['name'],
			'email'            => $data['email'],
			'birthday'         => $data['birthday'],
			'password'         => bcrypt($data['password']),
			'billing_address'  => $data['billing_address'],
			'shipping_address' => $data['shipping_address'],
			'telephone_number' => $data['telephone_number'],
			'mobile_number'    => $data['mobile_number'],
		]);

		Mail::send('emails.welcome', $data, function ($message) use ($data) {

			$message->from('care@shopmanila.com');
			$message->subject("Welcome to Shop Manila!");
			$message->to($data['email']);
		});


		//Function to send email to mail chimp

		if (env('APP_ENV') === 'prod') {
			if (isset($data['sign_up_newsletter'])) {

				$api_key = env('MAILCHIMP_API_KEY');
				$list_id = env('MAILCHIMP_LIST_ID');
				$api = new MCAPI($api_key);
				$merge_vars = ['FNAME' => 'Mon', 'LNAME' => 'Velez'];

				$retval = $api->listSubscribe($list_id, $data['email'], $merge_vars, 'html', false, true);
			}
		}


		return $customer;

	}

}
