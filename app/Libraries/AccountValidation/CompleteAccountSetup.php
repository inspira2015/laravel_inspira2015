<?php
namespace App\Libraries\AccountValidation;

use App\Model\Entity\UserAffiliation;
use App\Model\Entity\UserVacationalFunds;

use Carbon; 


class CompleteAccountSetup 
{
	private $users_id;
	private $usersAffDao;
	private $usersVacDao;

	public function  __construct(UserAffiliation $userAff,UserVacationalFunds $userVac)
	{
		$this->usersAffDao = $userAff;
		$this->usersVacDao = $userVac;

	}

	public function setUsersID( $usersID = FALSE )
	{
		if ( $usersID == FALSE )
		{
			throw new Exception('Invalid Users ID.');
		}
		$this->users_id = $usersID;
	}

	private function validate( )
	{


	}


	public function checkUserSetup()
	{
	}

	
}