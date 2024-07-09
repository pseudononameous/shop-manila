<?php namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        // Using class based composers...
//        View::composer('includes.sidebar', 'App\Http\ViewComposers\CategoryComposer');

		view()->composer(
			['includes.sidebar', 'public.items', 'public.search', 'includes.footer', 'includes.nav'], 'App\Http\ViewComposers\CategoryComposer'
		);

	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
