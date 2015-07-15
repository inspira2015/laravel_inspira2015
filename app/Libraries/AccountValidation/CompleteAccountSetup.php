<?php
namespace App\Libraries\AccountValidation;

use App\Model\Entity\UserAffiliation;
use App\Model\Entity\UserVacationalFunds;
use App\Model\Entity\UserVacFundLog;

/*
	|--------------------------------------------------------------------------
	| CompleteAccountSetup
	|--------------------------------------------------------------------------
	|
	| This library check if user Account setup is finished or not.
	| 
	|
	*/

	

class CompleteAccountSetup 
{
	private $users_id;
	private $usersAffDao;
	private $usersVacDao;

	/**
	 * Initialize Dao Models - 
	 *
	 * @return void
	 */
	public function  __construct(UserAffiliation $userAff,UserVacFundLog $userVac)
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

	/**
	 * Checks if user setup Account its finished or not
	 *
	 * @return Boolean
	 */
	private function validate( )
	{
		if ( ! $this->checkAffiliation()  )
		{
			return FALSE;
		}

		if ( ! $this->checkVacFund()  )
		{
			return FALSE;
		}

		if ( ! $this->checkCreditCard()  )
		{
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * Get Result of private function validate
	 *
	 * @return Boolean
	 */
	public function checkValidAccount()
	{
		return $this->validate();
	}

	/**
	 * Get Affiliation Data
	 *
	 * @return FALSE or UserAffDao
	 */
	public function checkAffiliation()
	{
		return $this->usersAffDao->getByUsersId( $this->users_id );

	}

	/**
	 * Get Vacational Fund log
	 *
	 * @return FALSE or usersVacDao
	 */
	public function checkVacFund()
	{
		return $this->usersVacDao->getByUsersId( $this->users_id );

	}

	/**
	 * Get Credit Card INfo
	 *
	 * @return FALSE or usersVacDao
	 */
	public function checkCreditCard()
	{
		return TRUE;
	}


	public function getRedirect()
	{
		if($this->checkAffiliation==FALSE)
		{
			return redirect('/affiliation');
		}

		if($this->checkVacFund==FALSE)
		{
			return redirect('/affiliation');
		}

		return redirect('/useraccount');
	}

}