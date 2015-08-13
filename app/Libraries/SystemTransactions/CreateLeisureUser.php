<?php

namespace App\Libraries\SystemTransactions;
use App\Model\Code as Code;
use Carbon; 
use App\Model\Entity\SystemTransactionEntity;
use App\Model\Entity\UserAffiliation;
use App\Model\Dao\UserDao;
use App;

class CreateLeisureUser extends AbstractTransactions 
{
	private $db_code;
	private $error_array;
	private $valid;
	private $userAffiliationDao;
	private $userDao;

	private $affiliationPaymentArray;


	public function  __construct( SystemTransactionEntity $systemTransactions,
								  UserDao $userDao,
								  UserAffiliation $userAffDao )
	{
		parent::__construct( $systemTransactions );
		$this->userAffiliationDao = $userAffDao;
		$this->userDao = $userDao;
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


	public function saveData()
	{
		$checkCreateLeisureUser = $this->checkCreateLeisureUser();
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