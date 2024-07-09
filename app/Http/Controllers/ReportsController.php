<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OrderDetail;
use App\Repositories\Report\Contracts\ReportInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use JavaScript as Js;
use Assets;

class ReportsController extends Controller {
	/**
	 * @var ReportInterface
	 */
	private $reportInterface;
	/**
	 * @var OrderDetail
	 */
	private $orderDetail;

	/**
	 * @param ReportInterface $reportInterface
	 * @param OrderDetail $orderDetail
	 */
	public function __construct(ReportInterface $reportInterface, OrderDetail $orderDetail) {

		$this->reportInterface = $reportInterface;
		$this->orderDetail = $orderDetail;

		$this->executeMiddlewares();
	}

	public function executeMiddlewares() {

		$this->middleware('adminOnly');
	}


	public function sales() {

		Assets::add([
			URL::asset('js/reports/ReportSrvc.js'),
			URL::asset('js/reports/SalesReportCtrl.js'),
		]);

		return view('admin.reports.sales');
	}

	public function getSalesReport($filter) {
		$sales = $this->reportInterface->getSalesReport($filter);

		$parsedSales = $this->reportInterface->parseSalesReport($sales, $filter);

		return $parsedSales;

	}

	public function orders() {

		$store = '';
		$dateFrom = '';
		$dateTo = '';


		Assets::add([
			URL::asset('js/reports/OrdersReportCtrl.js'),
		]);

		$data = $this->orderDetail->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));

		return view('admin.reports.orders', compact('data', 'store', 'dateFrom', 'dateTo'));
	}

	public function searchOrdersReport(Request $request) {

		$req = $request->all();

		$store = '';
		$dateFrom = '';
		$dateTo = '';

		if(isset($req['store'])){

			$store = $req['store'];
		}

		if(isset($req['dateFrom'])){

			$dateFrom = $req['dateFrom'];
			$dateTo = $req['dateTo'];
		}


		if ($store || $dateFrom) {
			$data = $this->orderDetail->whereHas('item.store', function ($q) use ($store) {

				if($store){
					$q->where('name', 'LIKE', "%$store%");
				}

			})
				->filterDate($dateFrom, $dateTo)
				->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));
		}

		return view('admin.reports.orders', compact('data', 'store', 'dateFrom', 'dateTo'));

	}

}
