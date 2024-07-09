<?php namespace App\Http\Middleware;

use App\Event;
use Closure;

class DisableEvent {
	/**
	 * @var Event
	 */
	private $event;

	/**
	 * DisableEvent constructor.
	 * @param Event $event
	 */
	public function __construct(Event $event){

		$this->event = $event;
	}


	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		$events = $this->event->all();

		$today = date('Y-m-d H:i:s');
		$time = date('H:i:s');


		/*Disable events before start date*/
		$e = $this->event
			->where('start_date', '>=', $today)
			->update(['status' => 0]);

		/*Disable events past end date*/
		$e = $this->event
			->where('end_date', '<=', $today)
			->update(['status' => 0]);


		/*Get valid events*/
		$validEvents = $this->event
			->where('start_date', '<=', $today)
			->where('end_date', '>=', $today)
			->get();

		/*Activate valid events before checking for time activation*/
		$this->event
			->where('start_date', '<=', $today)
			->where('end_date', '>=', $today)
			->update(['status' => 1]);


		/*Check if valid events has time activation*/

		foreach($validEvents as $event){

			if($event->start_day_time != null){

				if( ($event->start_day_time <= $time) && ($event->end_day_time >= $time) ){
					$event->status = 1;
					$event->save();
				}else{
					$event->status = 0;
					$event->save();
				}

			}

		}


		return $next($request);
	}

}
