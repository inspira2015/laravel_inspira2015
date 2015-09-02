<?php
namespace App\Libraries;

use App\Model\Entity\UserVacationalFunds;
use App\Model\Entity\UsersPointsEntity;
/*
	|--------------------------------------------------------------------------
	| CompleteAccountSetup
	|--------------------------------------------------------------------------
	|
	| This library check if user Account setup is finished or not.
	| 
	|
	*/

	

class GetPointsLastBalance 
{
	private $usersPointsDao;
	private $users_id;
	private $lastRow;

	public function __construct(UsersPointsEntity $usersPoints)
	{
		$this->usersPointsDao = $usersPoints;
	}


	public function setUserId( $users_id )
	{
		$this->users_id= $users_id;
	}


	public function checkBalance()
	{
		$this->lastRow =  $this->usersPointsDao->getLatestByUserId( $this->users_id );

	}

	public function getLastTransaction()
	{
		$this->checkBalance();
		if( empty( $this->lastRow ) )
		{
			return FALSE;
		}
		return $this->lastRow;
	}

	public function getCurrentBalance()
	{
		$this->checkBalance();
		if( empty( $this->lastRow ) )
		{
			return 0;
		}
		return $this->lastRow->balance;
	}

}