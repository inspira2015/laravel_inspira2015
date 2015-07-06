<?php namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Request;
use Str; 

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		$this->setRouteLog();
		parent::boot($router);
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router)
	{
		$router->group(['namespace' => $this->namespace], function($router)
		{
			require app_path('Http/routes.php');
		});
	}
	
	private function setRouteLog(){
		$module = Request::segment(1);
		$action = Request::segment(2);
		$method = Request::method();

		if( $module ) 
		{
			$controller = Str::title( $module ).'Controller';
			$route = "\App\\Http\\Controllers\\{$controller}";
			if( $module == 'password' || $module == 'auth' )
			{
				$route = "\App\\Http\\Controllers\\Auth\\{$controller}";	
			}
			
			return App::make($route)->logAction($module, $action, $method);
		}
			
	}

}
