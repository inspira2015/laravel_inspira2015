<?php

namespace App\Libraries\SystemTransactions;
use App\Model\Code as Code;
use Carbon; 
use App\Model\Entity\SystemTransactionEntity;
use App\Model\Entity\UserAffiliation;
use App\Model\Dao\UserDao;
use App\Model\Entity\CodesUsedEntity;
use App\Libraries\AddInspiraPoints;
use App\Libraries\UpdateDataBaseLeisureMember;

use App;

class CreateLeisureUser extends AbstractTransactions 
{
	private $db_code;
	private $error_array;
	private $valid;
	private $userAffiliationDao;
	private $userDao;
	private $codesUsedDao;
	private $affiliationPaymentArray;
	private $inspiraPoints;
	private $leisureLoyaltyResponse;
	private $updateDBLeisuerMember;


	public function  __construct( SystemTransactionEntity $systemTransactions,
								  UserDao $userDao,
								  UserAffiliation $userAffDao,
								  CodesUsedEntity $codesUsed,
								  AddInspiraPoints $inspiraPoints,
								  UpdateDataBaseLeisureMember $updateDbLeisure )
	{
		parent::__construct( $systemTransactions );
		$this->userAffiliationDao = $userAffDao;
		$this->userDao = $userDao;
		$this->codesUsedDao = $codesUsed;
		$this->inspiraPoints = $inspiraPoints;
		$this->updateDBLeisuerMembere = $updateDbLeisure;
	}


	public function setAffiliationPayment( Array $affiliationPayment )
	{
		$this->affiliationPaymentArray = $affiliationPayment;
	}


	public function getCodePoints()
	{
		$codesUsed = $this->codesUsedDao->getCodesUsedByUserId( $this->objUser->id );
		$points = (int)$codesUsed->code->points;
		if($points < 0 )
		{
			return 0;
		}
		return $points;
	}



	private function AddPoints( $transaction_id )
	{
		$this->inspiraPoints->setDate( date('Y-m-d') );
		$this->inspiraPoints->setUserId( $this->objUser->id );
		$this->inspiraPoints->setPoints( $this->getCodePoints() );
		$this->inspiraPoints->setReferenceNumber( 'CREATEUSER' . $this->objUser->id );
		$this->inspiraPoints->setDescription('Points Added From Registration Code');
		$this->inspiraPoints->AddUserPoints();
		$this->inspiraPoints->saveToDatabase( $transaction_id );
        return $this->inspiraPoints->getApiResponse();
	}


	public function saveData()
	{
		$this->updateDBLeisuerMembere->setUserId( $this->objUser );
		$responseLeisure = $this->updateDBLeisuerMembere->saveMemberId();

		/**
		 * Show the application welcome screen to the user.
		 *
		 * @return Response
		 */
		if ( $responseLeisure == TRUE )
		{
			$newMember = $this->updateDBLeisuerMembere->getNewMemberCheck();
			if($newMember)
			{
				$this->transactionInfo['description'] = 'Create Leisure MemberId';
			}
			else
			{
				$this->transactionInfo['description'] = 'Retrive Existing Leisure MemberId';
			}
		}

		$this->transactionInfo['code'] = $responseLeisure  ? "Success" : "Error";
		//$this->transactionInfo['json_data'] = $this->leisureLoyaltyResponse;
		$this->saveTransaction();


		$points = $this->getCodePoints();

		if ( $newMember )
		{
			$this->AddPoints( $this->transactionId );
		}

			
		return TRUE;
	}

	public function getErrors()
	{
		return TRUE;
	}
}