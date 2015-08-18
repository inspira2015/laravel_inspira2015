<?php

namespace App\Libraries\SystemTransactions;
use App\Model\Code as Code;
use Carbon; 
use App\Model\Entity\SystemTransactionEntity;
use App\Model\Entity\UserAffiliation;
use App\Model\Dao\UserDao;
use App\Model\Entity\CodesUsedEntity;
use App\Libraries\AddInspiraPoints;

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


	public function  __construct( SystemTransactionEntity $systemTransactions,
								  UserDao $userDao,
								  UserAffiliation $userAffDao,
								  CodesUsedEntity $codesUsed,
								  AddInspiraPoints $inspiraPoints )
	{
		parent::__construct( $systemTransactions );
		$this->userAffiliationDao = $userAffDao;
		$this->userDao = $userDao;
		$this->codesUsedDao = $codesUsed;
		$this->inspiraPoints = $inspiraPoints;
	}


	public function setAffiliationPayment( Array $affiliationPayment )
	{
		$this->affiliationPaymentArray = $affiliationPayment;
	}


	public function checkUserAffiliation()
	{
		$userAffiliation = $this->userAffiliationDao->getAffiliationByUsersId( $this->objUser->id );
		if( $userAffiliation !=FALSE )
		{
			return $userAffiliation[0];
		}
		return FALSE;
	}

	

	private function getPrefix()
	{
		$prefixForMembership = "";
		if (App::environment('production', 'staging'))
		{
    		$prefixForMembership = 'INSPIRA';
		}
		else
		{
    		$prefixForMembership = 'TESTUS';
		}
		return $prefixForMembership;
	}

	public function generateLeisureMemberShip()
	{
		$temp = $this->getPrefix();
		return (string)$temp . $this->objUser->id;
	}


	public function getCodePoints()
	{
		$codesUsed = $this->codesUsedDao->getCodesUsedByUserId( $this->objUser->id );
		$points = $codesUsed->code->points;
		if($points < 0 )
		{
			return 0;
		}
		return (int)$points;
	}



	public function checkCreateLeisureUser()
	{
		$userAffiliation = $this->checkUserAffiliation();

		$postData[0] = array(
		    "firstName" => $this->objUser->name, 
		 	"lastName" => $this->objUser->last_name, 
		 	"email" => $this->objUser->email,
			"languageCode"=> strtoupper($this->objUser->language),
			"mtierId"=> (int)$userAffiliation->affiliation->tier_id,
			"memberId"=> $this->generateLeisureMemberShip(),
		);

		$context = stream_context_create(array(
		    'http' => array(
		        'method' => 'POST',
		        'header' => "Content-Type: application/json\r\n",
		        'content' => json_encode($postData)
		    )
		));

		$response = file_get_contents('https://api.leisureloyalty.com/v3/members?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH&', FALSE, $context);

		$stdResponse = json_decode($response);
		if ($stdResponse->success == 'OK' )
		{
			return TRUE;
		}
		return FALSE;

	} 


	private function AddPoints()
	{
		$this->inspiraPoints->setDate( date('Y-m-d') );
		$this->inspiraPoints->setUserId( $this->objUser->id );
		$this->inspiraPoints->setPoints( $this->getCodePoints() );
		$this->inspiraPoints->setReferenceNumber( 'CREATEUSER' . $this->objUser->id );
		$this->inspiraPoints->setDescription('Points Added From Registration Code');
        return $this->inspiraPoints->AddUserPoints();
	}


	public function saveData()
	{
		$checkCreateLeisureUser = $this->checkCreateLeisureUser();
		$points = $this->getCodePoints();
		if ($checkCreateLeisureUser == TRUE && $points > 0 )
		{
			$this->AddPoints();
		}


		$this->transactionInfo['code'] = $checkCreateLeisureUser  ? "Success" : "Error";
		$this->saveTransaction();
		
		if ( $checkCreateLeisureUser )
		{
			$this->userDao->exchangeArray( array( 'id' 		=> $this->objUser->id,
												 'leisure_id' =>	$this->generateLeisureMemberShip() ) );
			$this->userDao->save();
		}

		return TRUE;
	}

	public function getErrors()
	{
		return TRUE;
	}
}