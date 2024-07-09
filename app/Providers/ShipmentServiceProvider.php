<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ShipmentServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('\App\Repositories\Shipment\Contracts\ShipmentInterface', function()
		{
			return new \App\Repositories\Shipment\ShipmentRepository;
		});
	}

}
