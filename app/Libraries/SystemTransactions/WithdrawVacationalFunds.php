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

class WithdrawVacationalFunds extends AbstractTransactions 
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

	private $withdrawAmount;
	private $withdrawCurrency;


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


	public function setWithdrawAmount( $amount )
	{
		$this->withdrawAmount = $amount;
	}


	public function setWithdrawCurency( $curency )
	{
		$this->withdrawCurrency = $curency;
	}


	public function saveData()
	{
		$this->lastUserBalance->setUserId( $this->objUser->id );
		$lastBalance = $this->lastUserBalance->getCurrentBalance();
		if($lastBalance <  $this->withdrawAmount)
		{
			$this->transactionInfo['code'] = "Error";
			$this->transactionInfo['description'] = "Not enought balance for witdraw";
			$this->saveTransaction();
			return FALSE;
		}
		$total = $lastBalance - $this->withdrawAmount;

		if( !isset( $this->userVacationlArray['users_id'] ) )
		{
			$this->userVacationlArray['users_id'] = $this->objUser->id;
		}

		$this->userVacationlArray['transaction_id'] = $this->transactionId;
		$this->userVacationlArray['description'] = 'Leisure Loyalty Api Withdraw';
		$this->userVacationlArray['added_amount'] = 0;
		$this->userVacationlArray['substracted_amount'] = $this->withdrawAmount;
		$this->userVacationlArray['currency'] = $this->withdrawCurrency;
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