<?php namespace App\Providers;

use App\CartDetail;
use App\CartHeader;
use App\Item;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider {

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
		$this->app->bind('\App\Repositories\Cart\Contracts\CartInterface', function()
		{
			return new \App\Repositories\Cart\CartRepository;
		});
	}

}
