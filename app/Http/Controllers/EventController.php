<?php namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Assets;
use Illuminate\Support\Facades\URL;
use JavaScript as Js;

class EventController extends BaseController {
	/**
	 * @var Event
	 */
	private $event;

	/**
	 * EventController constructor.
	 * @param Event $event
	 */
	public function __construct(Event $event){

		$this->event = $event;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Assets::add([
			URL::asset('js/event/EventListCtrl.js'),
			URL::asset('js/event/EventSrvc.js'),
		]);

		$data = $this->event->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));

		return view('admin.events.list', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		Assets::add([
			URL::asset('js/event/AddEventCtrl.js'),
			URL::asset('js/event/EventSrvc.js'),
		]);

		$ctrl = 'AddEventCtrl';
		$title = 'Add';

		return view('admin.events.form', compact('ctrl', 'title'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Requests\UpdateEventRequest|Request $request
	 * @return Response
	 */
	public function store(Requests\UpdateEventRequest $request)
	{
		$data = $request->all();


		if (isset($data['start_date'])) {
			$c = new Carbon($data['start_date']);
			$data['start_date'] = $c->setTimezone('Asia/Manila')->toDateTimeString();
		}

		if (isset($data['end_date'])) {
			$c = new Carbon($data['end_date']);
			$data['end_date'] = $c->setTimezone('Asia/Manila')->toDateTimeString();
		}

		if (isset($data['start_day_time'])) {
			$c = new Carbon($data['start_day_time']);
			$data['start_day_time'] = $c->setTimezone('Asia/Manila')->toTimeString();
		}

		if (isset($data['end_day_time'])) {
			$c = new Carbon($data['end_day_time']);
			$data['end_day_time'] = $c->setTimezone('Asia/Manila')->toTimeString();
		}

		$model = 'App\Event';
		$data['slug'] = $this->makeSlug($data['name'], $model);

		$r = $this->event->create($data);

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
			URL::asset('js/event/EditEventCtrl.js'),
			URL::asset('js/event/EventSrvc.js'),
		]);

		Js::put(['id' => $id]);

		$ctrl = 'EditEventCtrl';
		$title = 'Edit';

		return view('admin.events.form', compact('ctrl', 'title'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Requests\UpdateEventRequest|Request $request
	 * @param  int $id
	 * @return Response
	 */
	public function update(Requests\UpdateEventRequest $request, $id)
	{
		$data = $request->all();

		$event = $this->event->find($id);


		if (isset($data['start_day_time'])) {
			$c = new Carbon($data['start_day_time']);
			$data['start_day_time'] = $c->setTimezone('Asia/Manila')->toTimeString();
		}

		if (isset($data['end_day_time'])) {
			$c = new Carbon($data['end_day_time']);
			$data['end_day_time'] = $c->setTimezone('Asia/Manila')->toTimeString();
		}

		$event->fill($data)
			->save();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->event->destroy($id);
	}

	/**
	 * Retrieve single record
	 * @param  int $id
	 * @return object
	 */
	public function getRecord($id)
	{
		return $this->event->with('eventImage')->find($id);
	}

	public function getEvents() {
		return $this->event->all();
	}
}
