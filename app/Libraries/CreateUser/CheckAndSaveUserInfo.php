<?php
namespace App\Libraries\CreateUser;


/*
	|--------------------------------------------------------------------------
	| Final validataion befor user creation
	|--------------------------------------------------------------------------
	|
	| This library stores a User in to the DB
	| 
	|
*/


class CheckAndSaveUserInfo
{

	private $storeData;
	private $userDao;
	private $codeDao;
	private $affDao;
	private $vacDao;

	public function __construct($userDao, $codeDao, $affiliationDao, $vacationDao)
	{
		$this->userDao = $userDao;
		$this->codeDao = $codeDao;
		$this->affDao = $affiliationDao;
		$this->vacDao = $vacationDao;
	}

	public function setUserPost($data = FALSE)
	{
		return $this->checkPost('User',$data);
	}


	public function setCodePost($data =FALSE )
	{
		return $this->checkPost('Code',$data);
	}


	public function setAffiliationPost($data = FALSE)
	{
		return $this->checkPost('Affiliation',$data);
	}


	public function setVacationFundPost($data = FALSE)
	{
		return $this->checkPost('VacationFund',$data);
	}


	private function checkPost($method,$data)
	{
		if ( $data == FALSE || empty($data) )
		{
			return FALSE;
		}
		$this->storeData[$method] = $data;
		return TRUE;
	}








}