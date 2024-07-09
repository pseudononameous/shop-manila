<?php namespace App\Http\Controllers;

use App\City;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CityController extends Controller {

	/**
	 * @param City $city
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function getCities(City $city) {
		return $city->all();
	}

}
