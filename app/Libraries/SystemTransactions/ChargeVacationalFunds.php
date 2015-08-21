<?php

namespace App\Libraries\SystemTransactions;
use App\Model\Code as Code;
use Carbon; 
use App\Model\Entity\SystemTransactionEntity;
use App\Model\Entity\UserAffiliationPaymentEntity;
use App\Model\Entity\UserAffiliation;
use App\Model\Entity\UserVacFundLog;
use App\Model\Entity\UserVacationalFunds;
use App\Libraries\GetLastBalance;

class ChargeVacationalFunds extends AbstractTransactions 
{
	private $db_code;
	private $error_array;
	private $valid;
	private $userAffiliationDao;
	private $userVacFundLogDao;

	private $userVacationalFund;
	private $userVacationFundDao;
	private $userVacationlArray;
	private $lastUserBalance;


	public function  __construct( SystemTransactionEntity $systemTransactions,
								  UserVacFundLog $userVacFundLog,
								  UserVacationalFunds $userVacFund,
								  GetLastBalance $lastBalance )
	{
		parent::__construct( $systemTransactions );
		$this->userVacationFundDao = $userVacFund;
		$this->userVacFundLogDao = $userVacFundLog;
		$this->lastUserBalance = $lastBalance;
	}


	public function setVacationalFund( Array $userVacationalFund )
	{
		$this->userVacationlArray = $userVacationalFund;
	}


	private function checkUserVacationalLog()
	{
		$userVacFund = $this->userVacFundLogDao->getByUsersId( $this->objUser->id );
		if( $userVacFund !=FALSE )
		{
			return $userVacFund[0];
		}
		return FALSE;
	}



	public function saveData()
	{
		$this->saveTransaction();
		$userVacationalLog = $this->checkUserVacationalLog();
		$this->lastUserBalance->setUserId($this->objUser->id );
		$lastBalance = $this->lastUserBalance->getCurrentBalance();
		$total = $lastBalance + $userVacationalLog->amount;
		$this->userVacationlArray['transaction_id'] = $this->transactionId;
		$this->userVacationlArray['description'] = 'New Monthly Fund';
		$this->userVacationlArray['added_amount'] = $userVacationalLog->amount;
		$this->userVacationlArray['substracted_amount'] = 0; 
		$this->userVacationlArray['currency'] = $userVacationalLog->currency;
		$this->userVacationlArray['balance'] = $total;
		$this->userVacationFundDao->exchangeArray( $this->userVacationlArray );
		$this->userVacationFundDao->save();
		return TRUE;
	}

	public function getErrors()
	{
		return TRUE;
	}
}