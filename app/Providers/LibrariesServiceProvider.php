<?php 

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Model\Entity\UserAffiliation;
use App\Model\Entity\UserVacFundLog;

class LibrariesServiceProvider extends ServiceProvider {

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
		 $this->app->bind('App\Libraries\AccountValidation\CompleteAccountSetup', function($app) {
                return new \App\Libraries\AccountValidation\CompleteAccountSetup($app->make('\App\Model\Entity\UserAffiliation'), 
                	$app->make('\App\Model\Entity\UserVacFundLog'));
        });      


	}

}
