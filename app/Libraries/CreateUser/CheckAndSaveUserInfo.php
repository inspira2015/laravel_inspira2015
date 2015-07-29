<?php
namespace App\Libraries\CreateUser;
use App\Model\Dao\UserDao;
use App\Model\Dao\UserRegisteredPhoneDao as UserRegisteredPhone;
use App\Model\Entity\CodesUsedEntity;
use App\Model\Dao\CodeDao;
use App\Libraries\CodeValidator as CodeValidator;
use \App\Model\Entity\UserAffiliation;
use \App\Libraries\CodesOperations;


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
	private $codeOperations;
	private $errorArray;

	public function __construct(UserDao $userDao,CodeDao $codeDao, 
								UserAffiliation $affiliationDao, $vacationDao, $userPh, $usedCodes)
	{
		$this->userDao = $userDao;
		$this->codeDao = $codeDao;
		$this->affDao = $affiliationDao;
		$this->vacDao = $vacationDao;
		$this->userPhone = $userPh;
		$this->codesUsed = $usedCodes;
		$this->codeOperations = new CodesOperations($this->codesUsed, $this->codeDao);

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


	private function checkingCode()
	{
		$code = $this->codeDao->getByCode( $this->storeData['Code'] )->first();
		$this->codeOperations->setCode( $code );
		return $this->codeOperations->checkValid();
	}

	public function checkCode()
	{
		return $this->checkingCode();
	}


	public function saveData()
	{

		if ( $this->checkingCode() == FALSE )
		{
			$this->errorArray[] = "El codigo ya fue usado";
			return FALSE;
		}
		
		$this->userDao->exchangeArray( $this->storeData['User'] );
		$users_id = $this->userDao->save();
		$this->userDao->load( $users_id );
		$this->storeData['User']['users_id'] = $users_id;
		$this->userPhone->exchangeArray( $this->storeData['User'] );
		$last_phone_id = $this->userPhone->save();

		$this->codeOperations->setUserId( $users_id );
		$this->codeOperations->saveUsedCode();
		$this->codeOperations->markCodeUsed();


		$this->affDao->exchangeArray( array('users_id' => $users_id,'affiliations_id' => $this->storeData['Affiliation']['affiliation'],
											'active' =>1) );
		$this->affDao->save();

		exit;
		

	}








}