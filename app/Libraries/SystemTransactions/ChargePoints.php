<?php

namespace App\Libraries\SystemTransactions;
use App\Model\Code as Code;
use Carbon; 
use App\Model\Entity\SystemTransactionEntity;
use App\Libraries\GetPointsLastBalance;
use App\Libraries\AddInspiraPoints;

class ChargePoints extends AbstractTransactions 
{
	private $db_code;
	private $error_array;
	private $valid;
	private $addInspiraPoints;
	private $lastUserBalance;
	private $points;
	private $transactionId;


	public function  __construct( SystemTransactionEntity $systemTransactions,
								  GetPointsLastBalance $lastBalance )
	{
		parent::__construct( $systemTransactions );
		$this->lastUserBalance = $lastBalance;
	}


	public function setAddInspiraPoints( AddInspiraPoints $addpoints )
	{
		$this->addInspiraPoints = $addpoints;
	}



	private function checkAddInspiraPoints()
	{
		$this->addInspiraPoints->AddUserPoints();
		$this->transactionInfo['code'] = 'Error';
		if ( $this->inspiraPoints->getApiResponse() )
		{
			$this->transactionInfo['code'] = 'Success';
		}
		$this->transactionInfo['json_data'] = $this->inspiraPoints->getApiResponseJson();
		$this->saveTransaction();

		if ( $this->inspiraPoints->getApiResponse() )
		{
			$this->inspiraPoints->saveToDatabase( $this->transactionId );
		}
		
        return $this->inspiraPoints->getApiResponse();
	}


	public function saveData()
	{
		return $this->checkAddInspiraPoints();
	}

	public function getErrors()
	{
		return TRUE;
	}

}