<?php
namespace App\Libraries;
use Carbon; 
use App\Model\Dao\UserDao;
use App\Model\Entity\UserAffiliation;

class AddInspiraPoints 
{
	
	private $inputDate;
	private $userId;
	private $error_array;
	private $pointsToBeAdded;
	private $referenceNumber;
	private $description;

	private $userDao;
	private $UserAffiliationDao;
	private $inspiraOfferArray;


	public function  __construct( UserDao $userDao, UserAffiliation $userAffiliation )
	{
		$this->error_array = FALSE;
		$this->userDao = $userDao;
		$this->UserAffiliationDao = $userAffiliation;
		$this->inspiraOfferArray = array( 1 => 561, 
										  2 => 562,
										  3 => 563,
										  4 => 558,
										  5 => 559,
										  6 => 560,
										  7 => 0 );
	}



	public function setDate($date)
	{
		$this->inputDate = Carbon::createFromFormat('Y-m-d', $date);
	}


	public function setUserId( $user_id )
	{
		$this->userId = $user_id;
	}


	public function setPoints($number = FALSE)
	{
		$this->pointsToBeAdded = (int)$number;
	}


	public function setReferenceNumber($reference)
	{
		$this->referenceNumber = $reference;
	}


	public function setDescription($description)
	{
		$this->description = $description;
	}


	private function getUser()
	{
		$user = $this->userDao->getById( $this->userId );
		if( $user !=FALSE )
		{
			return $user;
		}
		return FALSE;
	}


	private function getAffiliation()
	{
		$userAffiliation = $this->UserAffiliationDao->getByUsersId( $this->userId );
		if( $userAffiliation !=FALSE )
		{
			return $userAffiliation[0];
		}

		return FALSE;
	}


	private function doPostToApi()
	{
		$user = $this->getUser();
		$userAffiliation = $this->getAffiliation();
		$id = $this->inspiraOfferArray[$userAffiliation->affiliations_id];
		$date = $this->inputDate->toDateString();
		$referenceNumber = '';

		if ( !empty( $this->referenceNumber ) )
		{
			$referenceNumber = $this->referenceNumber ;

		}
		

		$postData[0] = array(
			"id" => $id,
			"memberId" => (string)$user->leisure_id,
			"memberPoints" => $this->pointsToBeAdded,
			"txDateFormat" => $date,
			"txRefNo" => $referenceNumber,
			"txNotes" => $this->description,

		);
		$json = json_encode($postData);

		$headers = array( 'Content-Type: application/json' );

		$url = 'https://api.leisureloyalty.com/v3/award/offer?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH&';
		$ch = curl_init();

		// Set the url, number of GET vars, GET data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	private function checkApiCall()
	{
		$responseToCheck = $this->doPostToApi();
		$response = json_decode( $responseToCheck );
		if($response->success == 'OK')
		{
			return TRUE;
		}
		return FALSE;
	}



	public function AddUserPoints()
	{
		return $this->checkApiCall();
	}


	public function getResponse()
	{
		
	}


}