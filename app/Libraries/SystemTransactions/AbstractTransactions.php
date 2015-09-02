<?php
namespace App\Libraries\SystemTransactions;

use App\Model\Code as Code;
use Carbon; 
use App\Model\Entity\SystemTransactionEntity;


abstract class AbstractTransactions 
{
	protected $sysTransactionDao;
	protected $transactionInfo;
	protected $transactionId;
	protected $objUser;
	

	public function  __construct(SystemTransactionEntity $transactionDao)
	{
		$this->sysTransactionDao = $transactionDao;
	}

	public function setTransactionInfo(Array $info)
	{
		$this->transactionInfo = $info;
	}
	
	public function setUser($user)
	{
		$this->objUser = $user;
	}

	public function saveTransaction()
	{
		$this->sysTransactionDao->exchangeArray( $this->transactionInfo );
		$this->transactionId = $this->sysTransactionDao->save();

	}
	

	abstract public function saveData();

	abstract public function getErrors();
	
}