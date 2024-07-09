<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateItemRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => 'required',
			'discounted_price_end_date'=> 'after:discounted_price_start_date',

		];
	}

}
