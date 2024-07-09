<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateNewsRequest;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Assets;
use JavaScript as Js;

class NewsController extends Controller {
	/**
	 * @var News
	 */
	private $news;

	/**
	 * @param News $news
	 */
	public function __construct(News $news){

		$this->news = $news;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = $this->news->orderBy('id','desc')->paginate(\Config::get('constants.paginationLimit'));

		Assets::add([
			URL::asset('js/news/NewsListCtrl.js'),
			URL::asset('js/news/NewsSrvc.js')
		]);


		return view('admin.news.list', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		Assets::add([
			URL::asset('js/news/AddNewsCtrl.js'),
			URL::asset('js/news/NewsSrvc.js')
		]);

		$ctrl = 'AddNewsCtrl';
		$title = 'Add';

		return view('admin.news.form', compact('ctrl', 'title'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateNewsRequest|Request $request
	 * @return Response
	 */
	public function store(CreateNewsRequest $request)
	{
		$data = $request->all();

		$r = $this->news->create($data);

		return ['id' => $r->id];
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		Assets::add([
			URL::asset('js/news/EditNewsCtrl.js'),
			URL::asset('js/news/NewsSrvc.js'),
		]);

		Js::put(['id' => $id]);

		$ctrl = 'EditNewsCtrl';
		$title = 'Edit';

		return view('admin.news.form', compact('ctrl', 'title'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param CreateNewsRequest $request
	 * @param  int $id
	 * @return Response
	 */
	public function update(CreateNewsRequest $request, $id)
	{
		$data = $request->all();

		$news = $this->news->find($id);

		$news->fill($data)->save();

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->news->destroy($id);
	}

	/**
	 * Retrieve single record
	 * @param  int $id
	 * @return object
	 */
	public function getRecord($id)
	{
		return $this->news->with('newsImage')->find($id);
	}


}
