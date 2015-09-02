<?php

namespace App\Libraries\SystemTransactions;
use Carbon; 
use App\Model\Entity\SystemTransactionEntity;

class CreateCashReceipt extends AbstractTransactions 
{
	private $db_code;
	private $error_array;
	private $valid;

	public function  __construct( SystemTransactionEntity $systemTransactions )
	{
		parent::__construct( $systemTransactions );
	}

	public function saveData()
	{
		$this->saveTransaction();
		return TRUE;
	}

	public function getErrors()
	{
		return TRUE;
	}
}