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


class UpdateUserAffiliation extends CheckAndSaveUserInfo
{

	private $userId;
	private $currentAffiliation;


	public function __construct(UserDao $userDao,CodeDao $codeDao, 
								UserAffiliation $affiliationDao,UserVacFundLog $vacationDao, 
								UserRegisteredPhoneDao $userPh,CodesUsedEntity $usedCodes)
	{
		parent::__construct($userDao, $codeDao, $affiliationDao, $vacationDao, $userPh, $usedCodes);
	}


	public function setUserId( $user_id )
	{
		$this->userId = $user_id;
	}


	public function setCurrentAffiliation( $affiliation  )
	{
		$this->currentAffiliation = $affiliation;
	}


	private function doChange()
	{
		$affiliationData = $this->cleanAffiliationPost();
        $userCurrentAffiliation = $this->affDao->getById( $this->currentAffiliation );

        if($userCurrentAffiliation->affiliations_id == $affiliationData['affiliations_id'])
        {
        	return FALSE;
        }


		$this->affDao->exchangeArray( array( 'users_id' =>$this->userId,
											 'affiliations_id' => $affiliationData['affiliations_id'],
											 'active' => 1,
											 'amount' => $affiliationData['amount'],
											 'currency' => $affiliationData['currency'] ) );
		$this->affDao->save();

		$this->affDao->load( $this->currentAffiliation );
		$this->affDao->active = 0;
		$this->affDao->save();
		return TRUE;

	}


	public function changeAffilition()
	{
		return $this->doChange();
	}

}