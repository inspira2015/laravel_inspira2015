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
		$this->app->bind('App\Model\Dao\UserRegisteredPhoneDao');
		$this->app->bind('App\Model\Entity\CodesUsedEntity');
		$this->app->bind('App\Model\Entity\UserAffiliation');
		$this->app->bind('App\Model\Entity\UserVacationalFunds');
		$this->app->bind('App\Model\Entity\UserVacFundLog');
		$this->app->bind('App\Model\Entity\Affiliations');
		$this->app->bind('App\Model\Entity\ExchangeRateEntity');
		$this->app->bind('App\Model\Entity\UserPaymentInfoEntity');


	}

}
