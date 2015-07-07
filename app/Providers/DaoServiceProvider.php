<?php 

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DaoServiceProvider extends ServiceProvider {

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
		//
		$this->app->bind('App\Model\Dao\CodeDao');
		$this->app->bind('App\Model\Dao\UserDao');
		$this->app->bind('App\Model\Entity\UserRegisteredPhone');
		$this->app->bind('App\Model\Entity\CodesUsedEntity');

	}

}
