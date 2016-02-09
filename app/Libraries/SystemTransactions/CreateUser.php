<?php

namespace App\Libraries\SystemTransactions;
use App\Model\Code as Code;
use Carbon; 
use App\Model\Entity\SystemTransactionEntity;
use App\Model\Entity\UserAffiliation;
use App\Model\Dao\UserDao;
use App\Model\Entity\CodesUsedEntity;
use App\Libraries\UpdateDataBaseLeisureMember;

use App;

class CreateUser extends AbstractTransactions 
{
	private $db_code;
	private $error_array;
	private $valid;
	private $userAffiliationDao;
	private $userDao;
	private $codesUsedDao;
	private $affiliationPaymentArray;
	private $leisureLoyaltyResponse;
	private $updateDBLeisuerMember;


	public function  __construct( SystemTransactionEntity $systemTransactions,
								  UserDao $userDao,
								  UserAffiliation $userAffDao,
								  CodesUsedEntity $codesUsed,
								  UpdateDataBaseLeisureMember $updateDbLeisure )
	{
		parent::__construct( $systemTransactions );
		$this->userAffiliationDao = $userAffDao;
		$this->userDao = $userDao;
		$this->codesUsedDao = $codesUsed;
		$this->updateDBLeisuerMembere = $updateDbLeisure;
	}


	public function setAffiliationPayment( Array $affiliationPayment )
	{
		$this->affiliationPaymentArray = $affiliationPayment;
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

		return TRUE;
	}

	public function getErrors()
	{
		return TRUE;
	}
}