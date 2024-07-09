<?php namespace App\Repositories\Report;

use App\Repositories\Report\Contracts\ReportInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class ReportRepository implements ReportInterface {

	private $orderHeader;

	public function __construct() {
		$this->orderHeader = App::make('App\OrderHeader');
	}

	public function getSalesReport($filter) {

		$from = $this->getFrom($filter);
		$to = $this->getTo($filter);

		return $this->orderHeader->whereBetween('created_at', [$from, $to])->get();

	}

	/**
	 * Combine sum of data with same date
	 * @param $sales object
	 * @param $filter string [24hrs, thisWeek.. etc..]
	 * @return mixed
	 */
	public function parseSalesReport($sales, $filter) {

		$from = $this->getFrom($filter)->format('d');
		$to = $this->getTo($filter)->format('d');

		$salesData = [];

		for ($ctr = $from; $ctr <= $to; $ctr ++) {

			$grandTotal = 0;

			foreach ($sales as $sale) {

				if (Carbon::parse($sale->created_at)->format('d') == $ctr) {
					$grandTotal += $sale->grand_total;
				}

				$salesData[ $ctr ] = $grandTotal;
			}

		}

		$data = [
			'days'  => $ctr,
			'sales' => $salesData,
		];

		return $data;
	}


	public function getFrom($filter) {
		$date = Carbon::now();

		switch ($filter) {
			case '24hrs':
				$from = $date->startOfDay();
				break;

			case 'thisWeek':
				$from = $date->startOfWeek();
				break;

			case 'thisMonth':
				$from = $date->startOfMonth();
				break;

//			case 'thisYear':
//				$from = $date->startOfYear();
//				break;
//
//			case 'lifetime':
//				$from = $date->startOfCentury();
//				break;
		}

		return $from;

	}

	public function getTo($filter) {

		$date = Carbon::now();

		switch ($filter) {
			case '24hrs':
				$to = $date->endOfDay();
				break;

			case 'thisWeek':
				$to = $date->endOfWeek();
				break;

			case 'thisMonth':
				$to = $date->endOfMonth();
				break;

//			case 'thisYear':
//				$to = $date->endOfYear();
//				break;
//
//			case 'lifetime':
//				$to = $date->endOfCentury();
//				break;
		}


		return $to;
	}

}