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
	private $userPhone;
	private $codesUsed;

	public function __construct($userDao, $codeDao, $affiliationDao, $vacationDao, $userPh, $usedCodes)
	{
		$this->userDao = $userDao;
		$this->codeDao = $codeDao;
		$this->affDao = $affiliationDao;
		$this->vacDao = $vacationDao;
		$this->userPhone = $userPh;
		$this->codesUsed = $usedCodes;

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


	public function saveData()
	{
		$this->userDao->exchangeArray( $this->storeData['User'] );
		$users_id = $this->userDao->save();
		$this->userDao->load( $users_id );
		$this->storeData['User']['users_id'] = $users_id;
		$this->userPhone->exchangeArray( $this->storeData['User'] );
		$last_phone_id = $this->userPhone->save();
		

		$ObjCode = $this->codeDao->getByCode( $this->storeData['Code'] );

		if(!empty($ObjCode->all()))
		{
			$this->codesUsed->exchangeArray(array('codes_id' => $ObjCode->first()->id, 'users_id' =>$users_id));
			$this->codesUsed->save();
		}


		
		exit;
		//
		
			
			$full_nam = $this->userDao->name . ' ' . $this->userDao->last_name;
			$code = Session::get('code', FALSE);
			$ObjCode = $this->codeDao->getByCode($code);
			
			if(!empty($ObjCode->all()))
			{
				$this->codesUsed->exchangeArray(array('codes_id' => $ObjCode->first()->id, 'users_id' =>$users_id));
				$this->codesUsed->save();
			}

	}








}