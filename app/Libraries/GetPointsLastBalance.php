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


	public function setUserId($users_id)
	{
		$this->users_id= $users_id;
	}


	public function checkBalance()
	{
		$this->last_row =  $this->usersPointsDao->getLatestByUserId( $this->users_id );

	}

	public function getLastTransaction()
	{
		if( empty( $this->last_row ) )
		{
			return FALSE;
		}
		return $this->last_row;
	}

	public function getCurrentBalance()
	{
		if( empty( $this->last_row ) )
		{
			return 0;
		}
		return $this->last_row->balance;
	}

}