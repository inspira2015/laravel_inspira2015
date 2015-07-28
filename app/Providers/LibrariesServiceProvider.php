<?php 

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Model\Entity\Affiliations;
use App\Model\Entity\UserVacFundLog;
use App\Model\Dao\UserRegisteredPhoneDao;


class LibrariesServiceProvider extends ServiceProvider 
{

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
		$this->app->bind('App\Libraries\Affiliations\CheckCodeAffiliations', function($app) {
                return new \App\Libraries\Affiliations\CheckCodeAffiliations($app->make('\App\Model\Entity\Affiliations'),
					$app->make('\App\Model\Dao\CodeDao')
                	);
        });

		$this->app->bind('App\Libraries\CreateUser\CheckAndSaveUserInfo', function($app) {
                return new \App\Libraries\CreateUser\CheckAndSaveUserInfo($app->make('\App\Model\Dao\UserDao'),
					$app->make('\App\Model\Dao\CodeDao'),$app->make('\App\Model\Entity\UserAffiliation'),
					$app->make('\App\Model\Entity\UserVacFundLog'),$app->make('\App\Model\Dao\UserRegisteredPhoneDao'),
					$app->make('\App\Model\Entity\CodesUsedEntity')

                	);
        });



	}

}
