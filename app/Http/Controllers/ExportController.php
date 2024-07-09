<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller {
	/**
	 * @var OrderDetail
	 */
	private $orderDetail;

	/**
	 * @param OrderDetail $orderDetail
	 */
	public function __construct(OrderDetail $orderDetail) {

		$this->orderDetail = $orderDetail;
	}

	public function exportOrdersReport() {

		$store = Input::get('store');

		$store = Input::get('store');
		$dateFrom = Input::get('dateFrom');
		$dateTo = Input::get('dateTo');

		if (!$store) {
			$data = $this->orderDetail->orderBy('id', 'desc')->get();
		}

		if ($store) {

			$data = $this->orderDetail->whereHas('item.store', function ($q) use ($store) {
				$q->where('name', 'LIKE', "%$store%");
			})
				->filterDate($dateFrom, $dateTo)
				->orderBy('id', 'desc')->get();
		}

		Excel::create('Shop Manila - Orders', function ($excel) use ($data) {

			$excel->sheet('Excel sheet', function ($sheet) use ($data) {

				$sheet->setOrientation('landscape');

				foreach ($data as $key => $d) {
					$sheet->row(($key + 1), [
						$d->item->store->name,
						$d->orderHeader->customer->name,
						$d->orderHeader->order_number,
						$d->item->name . (isset($d->optionSize->name) ? ' Size: ' . $d->optionSize->name : ''),
						$d->price,
						date('M d, Y', strtotime($d->created_at)),
					]);

				}

			});

		})->download('xls');
	}

}
