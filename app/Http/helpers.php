<?php

use App\Event;

class Helper {

	public static function getCurrency() {
		return 'PHP';
	}

	public static function alphaNumberFormat($n) {

		if (!is_numeric($n) || ($n == 0)) return $n;


		$s = ["K", "M", "B", "T"];
		$out = "";
		while ($n >= 1000 && count($s) > 0) {
			$n = $n / 1000.0;
			$out = array_shift($s);
		}

		return round($n, max(0, 3 - strlen((int) $n))) . " $out";
	}

	public static function numberFormat($n) {
		if (!is_numeric($n) || ($n == 0)) return $n;

		return number_format($n, 2);
	}

	/**
	 * Display value if greater than 0 or n/a if not
	 * @param  str /dec/int $value
	 * @return int
	 */
	public static function valueOrNa($value) {

		if (is_numeric($value)) {
			$value = ceil($value);

			if ($value == 0.00) {
				$value = 'N/A';

			}

			return $value;

		}

		if ($value == '') {

			$value = 'N/A';

			return $value;
		}

		return $value;


	}

	/** Get price. Check if it's on sale or under an event
	 * @param $item
	 * @return mixed
	 */
	public static function getItemPrice($item) {

		$price = $item->price;

		if ($item->on_sale) {
			$price = $item->discounted_price;
		}

//		if (($item->event_id) && ($item->event->status)) {
//
//			$price = $item->event_price;
//		}

		return $price;
	}

	/**
	 * @param $price
	 * @param $discountedPrice
	 * @return string
	 */
	public static function getPercentDeducted($price, $discountedPrice) {

		$percent = (1 - ($discountedPrice / $price)) * 100;

		return round($percent) . '% off';
	}


}