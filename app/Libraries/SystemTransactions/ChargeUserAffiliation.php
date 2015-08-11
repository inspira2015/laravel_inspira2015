<?php

namespace App\Libraries\SystemTransactions;
use App\Model\Code as Code;
use Carbon; 
use App\Model\Entity\SystemTransactionEntity;
use App\Model\Entity\UserAffiliationPaymentEntity;
use App\Model\Entity\UserAffiliation;


class ChargeUserAffiliation extends AbstractTransactions 
{
	private $db_code;
	private $error_array;
	private $valid;
	private $userAffiliationDao;
	private $userAffDao;

	private $affiliationPaymentArray;


	public function  __construct( SystemTransactionEntity $systemTransactions,
								  UserAffiliationPaymentEntity $userPaymentDao,
								  UserAffiliation $userAffDao )
	{
		parent::__construct( $systemTransactions );
		$this->userAffiliationDao = $userPaymentDao;
		$this->userAffDao = $userAffDao;
	}


	public function setAffiliationPayment( Array $affiliationPayment )
	{
		$this->affiliationPaymentArray = $affiliationPayment;
	}


	private function checkUserAffiliation()
	{
		$userPayment = $this->userAffDao->getByUsersId( $this->objUser->id );
		if( $userPayment !=FALSE )
		{
			return $userPayment[0];
		}
		return FALSE;
	}

	public function saveData()
	{
		$this->saveTransaction();
		$userAffiliation = $this->checkUserAffiliation();


		$this->affiliationPaymentArray['transaction_id'] = $this->transactionId;
		$this->affiliationPaymentArray['affiliations_id'] = $userAffiliation->affiliations_id;
		$this->userAffiliationDao->exchangeArray( $this->userPaymentArray );
		$this->userAffiliationDao->save();
		return TRUE;
	}

	public function getErrors()
	{
		return TRUE;
	}
}