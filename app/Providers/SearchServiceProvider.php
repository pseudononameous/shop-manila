<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider {

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
		$this->app->bind('\App\Repositories\Search\Contracts\SearchInterface', function()
		{
			return new \App\Repositories\Search\SearchRepository;
		});
	}

}
