<?php namespace App\Http\Middleware;

use Closure;
use Cart as CartSession;
use App\Repositories\Cart\Contracts\CartInterface;
use Auth;

class MergeCarts {

	protected $cart;

	/**
	 * @var CartInterface
	 */
	private $cartInterface;

	/**
	 * @param CartInterface $cartInterface
	 */
	public function __construct(CartInterface $cartInterface) {
		$this->cartSession = CartSession::instance('shopping');
		$this->cartInterface = $cartInterface;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {

		/*Not currently in use.. Using mergecarts function from cartRepo.php*/
		
		if (Auth::customer()->check()) {


			$cart = $this->cartSession->content();


			foreach ($cart as $value) {


				$data = [
					'id'  => $value->id,
					'qty' => $value->qty,

				];

				$data['options'] = ['sizeId' => $value->options->sizeId];

				$this->cartInterface->add($data);

			}

        	$this->cartSession->instance('shopping')->destroy();

		}

		return $next($request);
	}

}
