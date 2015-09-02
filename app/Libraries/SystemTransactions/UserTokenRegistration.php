<?php

namespace App\Libraries\SystemTransactions;
use App\Model\Code as Code;
use Carbon; 
use App\Model\Entity\SystemTransactionEntity;
use App\Model\Entity\UserPaymentInfoEntity;


class UserTokenRegistration extends AbstractTransactions 
{
	private $db_code;
	private $error_array;
	private $valid;
	private $userPaymentDao;
	private $userPaymentArray;

	public function  __construct( SystemTransactionEntity $systemTransactions,
								  UserPaymentInfoEntity $userPaymentDao )
	{
		parent::__construct( $systemTransactions );
		$this->userPaymentDao = $userPaymentDao;
	}

	public function setUserPaymentInfo( Array $userPayment )
	{
		$this->userPaymentArray = $userPayment;
	}


	private function checkUserToken()
	{
		$userPayment = $this->userPaymentDao->getPaymentByUserId( $this->objUser->id )->first();
		if( empty($userPayment) )
		{
			return 0;
		}
		return $userPayment->id;
	}

	public function saveData()
	{
		$this->saveTransaction();
		$this->userPaymentArray['id'] = $this->checkUserToken();
		$this->userPaymentArray['transaction_id'] = $this->transactionId;
		$this->userPaymentDao->exchangeArray( $this->userPaymentArray );
		$this->userPaymentDao->transaction_id = $this->transactionId;
		$this->userPaymentDao->save();
		return TRUE;
	}

	public function getErrors()
	{
		return TRUE;
	}
}