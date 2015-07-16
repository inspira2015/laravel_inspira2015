<?php
namespace App\Libraries\Affiliations;

use App\Model\Entity\UserVacationalFunds;

/*
	|--------------------------------------------------------------------------
	| CheckCodeAffiliations
	|--------------------------------------------------------------------------
	|
	| This library check and gets Codes Affiliations
	| 
	|
	*/

	

class CheckCodeAffiliations 
{
	private $users_id;
	private $usersAffDao;
	private $usersVacDao;

	/**
	 * Initialize Dao Models - 
	 *
	 * @return void
	 */
	public function  __construct(UserAffiliation $userAff)
	{
		$this->usersAffDao = $userAff;
		$this->usersVacDao = $userVac;

	}

	/**
	 * Set Users Id
	 *
	 * @return void
	 */
	public function setUsersID( $usersID = FALSE )
	{
		if ( $usersID == FALSE )
		{
			throw new Exception('Invalid Users ID.');
		}
		$this->users_id = $usersID;
	}


}