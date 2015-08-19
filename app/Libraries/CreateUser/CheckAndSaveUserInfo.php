<?php
namespace App\Libraries\CreateUser;
use App\Model\Dao\UserDao;
use App\Model\Dao\UserRegisteredPhoneDao as UserRegisteredPhone;
use App\Model\Entity\CodesUsedEntity;
use App\Model\Dao\CodeDao;
use App\Libraries\CodeValidator as CodeValidator;
use App\Model\Entity\UserAffiliation;
use App\Libraries\CodesOperations;
use App\Model\Entity\UserVacFundLog;
use App\Model\Dao\UserRegisteredPhoneDao;
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
								UserAffiliation $affiliationDao,UserVacFundLog $vacationDao, 
								UserRegisteredPhoneDao $userPh,CodesUsedEntity $usedCodes)
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
		$userCode = 'default';
		if(!empty($this->storeData['Code']))
		{
			$userCode = $this->storeData['Code'];
		}
		$code = $this->codeDao->getByCode( $userCode )->first();
		$this->codeOperations->setCode( $code );
		return $this->codeOperations->checkValid();
	}

	public function checkCode()
	{
		return $this->checkingCode();
	}


	private function cleanAffiliationPost()
	{
		$temp_id = $this->storeData['Affiliation']['affiliation'];
		return array( 'affiliations_id' => $temp_id,
					  'amount' => (float)$this->storeData['Affiliation']['amount_' . $temp_id],
					  'currency' => $this->storeData['Affiliation']['currency_' . $temp_id],
			);
	}


	public function saveData()
	{
		if ( $this->checkingCode() == FALSE )
		{
			$this->errorArray[] = "El codigo ya fue usado";
			return FALSE;
		}
		$affiliationData = $this->cleanAffiliationPost();

		
		$this->userDao->exchangeArray( $this->storeData['User'] );
		$users_id = $this->userDao->save();
		$this->userDao->load( $users_id );
		$this->storeData['User']['users_id'] = $users_id;
		$this->userPhone->exchangeArray( $this->storeData['User'] );
		$last_phone_id = $this->userPhone->save();
		$this->codeOperations->setUserId( $users_id );
		$this->codeOperations->saveUsedCode();
		$this->codeOperations->markCodeUsed();
		$this->affDao->exchangeArray( array( 'users_id' => $users_id,
											 'affiliations_id' => $affiliationData['affiliations_id'],
											 'active' => 1,
											 'amount' => $affiliationData['amount'],
											 'currency' => $affiliationData['currency'] ) );
		$this->affDao->save();
		$this->vacDao->exchangeArray( array('users_id' => $users_id,'amount' => $this->storeData['VacationFund']['amount'],
											'active' =>1,'currency' => $this->storeData['VacationFund']['currency']) );
		$this->vacDao->save();
		return TRUE;
	}


	public function getUserDao()
	{
		return $this->userDao;
	}

}