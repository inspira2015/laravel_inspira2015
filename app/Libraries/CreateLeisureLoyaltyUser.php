<?php

namespace App\Libraries;
use App\Model\Entity\UserAffiliation;
use App\Model\User;
use App;
use App\Libraries\GeneratePaymentsDates;

class CreateLeisureLoyaltyUser 
{
	protected $objUser;
	private $userAffiliationDao;
	protected $newMemberFlag;
	protected $generatePaymentDate;
	protected $membersDays;

	public function __construct(UserAffiliation $userAffiliationDao)
	{
		$this->userAffiliationDao = $userAffiliationDao;
		$this->generatePaymentDate = new GeneratePaymentsDates( date('Y-m-d') );

	}

	public function setUserId( User $objUser )
	{
		$this->objUser = $objUser;
	}

	protected function setupTimes( $tier_id )
	{
		$tier_id = (int)$tier_id;
		
		if ( $tier_id  == 81 )
		{
			$this->membersDays = 365;
		}else if ( $tier_id  == 80 ){
			$this->membersDays = 7;
		}else{
			$this->membersDays = 30;
		}
	}


	protected function checkCreateLeisureUser()
	{
		$userAffiliation = $this->checkUserAffiliation();
		$memberId = $this->generateLeisureMemberShip();
		$this->setupTimes( $userAffiliation->affiliation->tier_id );

		$string_space = strpos($this->objUser->last_name, ' ');
		if($string_space !== FALSE) {
			$this->objUser->last_name = substr($this->objUser->last_name, 0, $string_space);
		}


		$postData[0] = array(
		    "firstName" => $this->objUser->name, 
		 	"lastName" => $this->objUser->last_name, 
		 	"email" => $this->objUser->email,
			"languageCode"=> strtoupper($this->objUser->language),
			"mtierId"=> (int)$userAffiliation->affiliation->tier_id,
			"countryCode" => $this->objUser->country,
			"memberId"=> $memberId,
			"memberDays" => $this->membersDays
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

		$this->leisureLoyaltyResponse = $response;
		if ($stdResponse->success == 'OK' )
		{
			$this->newMemberFlag = TRUE;
			return $memberId;
		}
// 		return FALSE;
		return $this->checkMemberIdByEmail();
	} 


	protected function checkMemberIdByEmail()
	{
		$json = file_get_contents('https://api.leisureloyalty.com/v3/members?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH&');
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

	public function getNewMemberCheck()
	{
		return $this->newMemberFlag;
	}


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


}
