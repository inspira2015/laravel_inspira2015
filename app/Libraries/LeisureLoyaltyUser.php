<?php

namespace App\Libraries;
use App;
use App\Model\Entity\UserAffiliation;
use App\Model\User;
use App\Libraries\GeneratePaymentsDates;

class LeisureLoyaltyUser
{
	protected $objUser;
	protected $membersDays;
	protected $tierId;
	protected $countryCode;
	protected $phones;

	public function __construct(UserAffiliation $userAffiliationDao)
	{
		$this->userAffiliationDao = $userAffiliationDao;
	}

	public function setUser( User $objUser )
	{
		$this->objUser = $objUser;
	}

	public function setTierId( $tier_id )
	{
		$this->tierId = $tier_id;
	}
	
	protected function setupTimes( $tier_id )
	{
		$this->membersDays = 30;
		if ( $tier_id  == 81 )
		{
			$this->membersDays = 365;
		}
		if ( $tier_id  == 80 ){
			$this->membersDays = 7;
		}
	}
	
	public function setCountryCode($code){
		$this->countryCode = $code;
	}

	public function setPhones( $phones){
		$this->phone = $phones;
	}
	protected function checkCreateLeisureUser()
	{
		$memberId = $this->generateLeisureMemberShip();
		$this->setupTimes(  (int) $this->tierId );

		$string_space = strpos($this->objUser->last_name, ' ');
		if($string_space !== FALSE) {
			$this->objUser->last_name = substr($this->objUser->last_name, 0, $string_space);
		}
		
		$postData[0] = array(
		    "firstName" => $this->objUser->name, 
		 	"lastName" => $this->objUser->last_name, 
		 	"email" => $this->objUser->email,
			"languageCode"=> strtoupper($this->objUser->language),
			"mtierId"=> (int) $this->tierId,
			"memberId"=> $memberId,
			"countryCode" => $this->countryCode,
			"memberDays" => $this->membersDays,
			"remainResortWeeks" => 0
		);

		$context = stream_context_create(array(
		    'http' => array(
		        'method' => 'POST',
		        'header' => "Content-Type: application/json\r\n",
		        'content' => json_encode($postData)
		    )
		));

		$response = file_get_contents('https://api.leisureloyalty.com/v3/members?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH', FALSE, $context);
		$stdResponse = json_decode($response);		

		if ($stdResponse->success == 'OK' )
		{
			$this->newMemberFlag = TRUE;
			return $memberId;
		}
		
		return FALSE;
	} 


	public function sendData($url, $method, $postData = array() ){
		
		$context = stream_context_create(array(
		    'http' => array(
		        'method' => $method,
		        'header' => "Content-Type: application/json\r\n",
		        'content' => json_encode($postData)
		    )
		));
		
		$response = file_get_contents($url, FALSE, $context);
		$stdResponse = json_decode($response);

		$this->leisureLoyaltyResponse = $response;
		return $stdResponse;
		
	}
	
	public function resortWeek( $week = 0 ){
		if($week != 0){
			 $url_send = "https://api.leisureloyalty.com/v3/member/addResortWeeks/{$this->objUser['leisure_id']}?resortWeeks={$week}&apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH";
			return $this->sendData($url_send, 'PUT', 0);
		}
		return false;
	}
	
	
	public function extend( $days ){
		$data = array( 'days' => $days );
		$url_send = "https://api.leisureloyalty.com/v3/members/extend/{$this->objUser['leisure_id']}?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH";
		return $this->sendData($url_send, 'PUT', $data);
	}
	
	protected function checkMemberIdByEmail()
	{
		$json = file_get_contents('https://api.leisureloyalty.com/v3/members?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH');
		$obj = json_decode($json, true);
		$data= $obj['data'];
		foreach($data as $user)
		{
			if( strcasecmp( $user['userId'], $this->objUser->email ) == 0 )
			{
				$this->newMemberFlag = FALSE;
				return  $user['memberId'];
			}
		}
		return FALSE;
	}
	
	public function getUser(){
		$url_send = "https://api.leisureloyalty.com/v3/members/{$this->objUser['leisure_id']}?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH";
		return $this->sendData($url_send, 'GET');
	}
	
	public function getResortWeeks(){
		$url_send = "https://api.leisureloyalty.com/v3/member/getResortWeeks/{$this->objUser['leisure_id']}?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH";
		$this->sendData($url_send, 'GET');
		$response = json_decode($this->getResponseJson());		
		return $response->data->resort_weeks;
	}

	public function getExpirationDate(){
		$user = $this->getUser();
		return $user->data->expirationDate;
	}
	public function getNewMemberCheck()
	{
		return $this->newMemberFlag;
	}

	//Create or retrive a memberID
	public function createOrRetriveMemberId()
	{
		return $this->checkCreateLeisureUser();
	}


	public function generateLeisureMemberShip()
	{
		$temp = $this->getPrefix();
		return (string)$temp . $this->objUser->id;
	}

	public function checkUserAffiliation()
	{
		$memberId = $this->objUser->id;
		$userAffiliation = $this->userAffiliationDao->getAffiliationByUsersId( $memberId );
		if( $userAffiliation !=FALSE )
		{
			return $userAffiliation[0];
		}
		return FALSE;
	}

	protected function getPrefix()
	{
		$prefixForMembership = "";
		if(@$_SERVER['SERVER_ADDR'] == '127.0.0.1'){
	    	$prefixForMembership = 'VIIMDEV0';
		}else{
			if (App::environment('production', 'staging'))
			{
		    	$prefixForMembership = 'INSPIRA';
			}
			else
			{
		    	$prefixForMembership = 'VIIM00';
			}
		}
		return $prefixForMembership;
	}


	public function getResponseJson()
	{
		return (string)$this->leisureLoyaltyResponse;
	}

	public function updateMember(){
		$data = array(
		 	"email" => $this->objUser->email,
			"languageCode"=> strtoupper($this->objUser->language),
			"countryCode"=> strtoupper($this->objUser->country),
			"currencyCode" => $this->objUser->currency,
			"cityName" => $this->objUser->city,
			"provinceName" => $this->objUser->state,
			"address1" => $this->objUser->address,
			"homePhone" => $this->phone->phone,
			"workPhone" => $this->phone->office,
			"cellPhone" => $this->phone->cellphone
	);


		$url_send = "https://api.leisureloyalty.com/v3/members/{$this->objUser['leisure_id']}?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH";
		
		$this->sendData($url_send, 'PUT', $data);
		$response = json_decode($this->getResponseJson());		
		
		if($response->success == 'OK'){
			return TRUE;
		}

		return FALSE;
	}
}
