<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		//'App\Http\Middleware\VerifyCsrfToken',
		'App\Http\Middleware\DisableEvent',
		'App\Http\Middleware\HttpsProtocol',
		'App\Http\Middleware\CheckDiscountPriceStatus',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'App\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'App\Http\Middleware\RedirectIfAuthenticated',
		'guestCustomer' => 'App\Http\Middleware\RedirectIfAuthenticatedCustomer',
		'authCustomer' => 'App\Http\Middleware\AuthCustomer',
		'validStore' => 'App\Http\Middleware\ValidStore',
		'validStoreCategory' => 'App\Http\Middleware\ValidStoreCategory',
		'validStoreItem' => 'App\Http\Middleware\ValidStoreItem',
		'mergeCarts' => 'App\Http\Middleware\MergeCarts',
		'adminOnly' => 'App\Http\Middleware\AdminOnly',
		'verifyIfOwnedItem' => 'App\Http\Middleware\VerifyIfOwnedItem',
		'saveCartAsTempOrder' => 'App\Http\Middleware\SaveCartAsTempOrder',
		'validSearchUrl' => 'App\Http\Middleware\ValidSearchUrl',
		'checkForCartContent' => 'App\Http\Middleware\CheckForCartContent',
		'validCartSession' => 'App\Http\Middleware\ValidCartSession',
		'validCheckoutSession' => 'App\Http\Middleware\ValidCheckoutSession',
		'hideInactiveItem' => 'App\Http\Middleware\HideInactiveItem',
	];

}
