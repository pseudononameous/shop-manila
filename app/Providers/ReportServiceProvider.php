<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider {

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
		$this->app->bind('\App\Repositories\Report\Contracts\ReportInterface', function()
		{
			return new \App\Repositories\Report\ReportRepository;
		});
	}

}
