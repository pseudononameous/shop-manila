<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PaypalServiceProvider extends ServiceProvider {

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
		$this->app->bind('\App\Repositories\Paypal\Contracts\PaypalInterface', function()
		{
			return new \App\Repositories\Paypal\PaypalRepository;
		});
	}

}
