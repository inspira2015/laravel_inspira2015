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

use App\Libraries\LeisureLoyaltyUser;

use App;
use Auth;

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
	private $leisureUser;

	public function  __construct( SystemTransactionEntity $systemTransactions,
								  UserDao $userDao,
								  UserAffiliation $userAffDao,
								  CodesUsedEntity $codesUsed,
								  AddInspiraPoints $inspiraPoints,
								  UpdateDataBaseLeisureMember $updateDbLeisure,
								  LeisureLoyaltyUser $leisureUser )
	{
		parent::__construct( $systemTransactions );
		$this->userAffiliationDao = $userAffDao;
		$this->userDao = $userDao;
		$this->codesUsedDao = $codesUsed;
		$this->inspiraPoints = $inspiraPoints;
		$this->updateDBLeisuerMembere = $updateDbLeisure;
		$this->leisureUser = $leisureUser;
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
	
	public function getLeisurePoints()
	{
		$this->leisureUser->setUser($this->objUser);
		return $this->leisureUser->getPointsBalance();
	}



	private function AddPoints( $transaction_id )
	{
		$this->inspiraPoints->setDate( date('Y-m-d') );
		$this->inspiraPoints->setUserId( $this->objUser->id );
		$this->inspiraPoints->setPoints( $this->getCodePoints() );
		$this->inspiraPoints->setReferenceNumber( 'CREATEUSER' . $this->objUser->id );
		$this->inspiraPoints->setDescription('Points Added From Registration Code');
		if($this->comparePoints() != 0){
			$this->inspiraPoints->AddUserPoints();
		}
		$this->inspiraPoints->saveToDatabase( $transaction_id );
        return $this->inspiraPoints->getApiResponse();
	}
	
	private function AddPointsToDB( $transaction_id )
	{
		$this->inspiraPoints->setDate( date('Y-m-d') );
		$this->inspiraPoints->setUserId( $this->objUser->id );
		$this->inspiraPoints->setPoints( $this->getCodePoints() );
		$this->inspiraPoints->setReferenceNumber( 'CREATEUSER' . $this->objUser->id );
		$this->inspiraPoints->setDescription('Points Added From Registration Code');
		$this->inspiraPoints->saveToDatabase( $transaction_id );
        return $this->inspiraPoints->getApiResponse();
	}
	
	private function comparePoints() {
		$points = $this->getCodePoints();
		$leisurePoints = $this->getLeisurePoints();
		$totalPoints = $points - $leisurePoints;
		return $totalPoints;
	}
	private function UpdatePoints($transaction_id )
	{
		$this->inspiraPoints->setDate( date('Y-m-d') );
		$this->inspiraPoints->setUserId( $this->objUser->id );
		$this->inspiraPoints->setPoints( $this->getCodePoints() );
		$this->inspiraPoints->setRemovedPoints( $this->comparePoints() );
		$this->inspiraPoints->setReferenceNumber( 'SETUSER' . $this->objUser->id );
		$this->inspiraPoints->setDescription('Points Removed From Registration Code');
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
		$newMember = $this->updateDBLeisuerMembere->getNewMemberCheck();
		if ( $responseLeisure == TRUE )
		{
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
		$this->transactionInfo['json_data'] = $this->updateDBLeisuerMembere->getResponseJson();
		$this->saveTransaction();


		$points = $this->getCodePoints();


/*
	
		if ( $newMember )
		{
			$this->AddPoints( $this->transactionId );
		}else{
*/
		//		$this->AddPoints( $this->transactionId );


			if($this->comparePoints() != 0){
				$this->UpdatePoints($this->transactionId);
			}else {
				$this->AddPoints( $this->transactionId );
			}

	//	}

			
		return TRUE;
	}

	public function getErrors()
	{
		return TRUE;
	}
}