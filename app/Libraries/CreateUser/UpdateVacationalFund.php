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


class UpdateVacationalFund extends CheckAndSaveUserInfo
{

	private $userId;
	private $currentVacFundId;


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

	public function setCurrentVacationalFund( $vacFundId )
	{
		$this->currentVacFundId = $vacFundId;
	}


	private function doChange()
	{
	
        $userCurrentVacationalFund = $this->vacDao->getById( $this->currentVacFundId );

        if( ( $userCurrentVacationalFund->amount == $this->storeData['VacationFund']['amount'] )  && 
        	  $userCurrentVacationalFund->currency == $this->storeData['VacationFund']['currency'] )
        {
        	return FALSE;
        }

        $this->vacDao->exchangeArray( array('users_id' => $this->userId,
        									'amount' => $this->storeData['VacationFund']['amount'],
											'active' =>1,
											'currency' => $this->storeData['VacationFund']['currency']) );
		$this->vacDao->save();



		$this->vacDao->load( $this->currentVacFundId );
		$this->vacDao->active = 0;
		$this->vacDao->save();
		return TRUE;

	}

	public function changeVacationalFund()
	{
		return $this->doChange();
	}
}
