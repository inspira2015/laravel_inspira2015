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
	private $points;


	public function  __construct( SystemTransactionEntity $systemTransactions)
	{
		parent::__construct( $systemTransactions );
	}


	public function setAddInspiraPoints( AddInspiraPoints $addpoints )
	{
		$this->addInspiraPoints = $addpoints;
	}


	private function checkAddInspiraPoints()
	{
		$this->addInspiraPoints->AddUserPoints();
		$this->transactionInfo['code'] = 'Error';

		if ( $this->addInspiraPoints->getApiResponse() )
		{
			echo "success";
			$this->transactionInfo['code'] = 'Success';
		}
		$this->transactionInfo['json_data'] = $this->addInspiraPoints->getApiResponseJson();
		$this->saveTransaction();


		$this->addInspiraPoints->saveToDatabase( $this->transactionId );
				
        return $this->addInspiraPoints->getApiResponse();
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