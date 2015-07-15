<?php
namespace App\Libraries\AccountValidation;

use App\Model\Entity\UserAffiliation;
use App\Model\Entity\UserVacationalFunds;
use App\Model\Entity\UserVacFundLog;

use Carbon; 


class CompleteAccountSetup 
{
	private $users_id;
	private $usersAffDao;
	private $usersVacDao;

	public function  __construct(UserAffiliation $userAff,UserVacFundLog $userVac)
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


	public function checkAffiliation()
	{

	}

	
	public function checkVacFund()
	{

	}


	public function checkCreditCard()
	{
		
	}

}