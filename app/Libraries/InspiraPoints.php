<?php
namespace App\Libraries;
use Carbon; 
use App\Model\Dao\UserDao;
use App\Model\Entity\UserAffiliation;
use App\Model\Entity\UsersPointsEntity;
use App\Libraries\GetPointsLastBalance;

class InspiraPoints 
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
	private $userPointsDao;
	private $transactionId;
	private $apiResponse;
	private $apiResponseJson;
	private $pointsBalance;


	public function  __construct( UserDao $userDao, 
								  UserAffiliation $userAffiliation,
								  UsersPointsEntity $usersPoints,
								  GetPointsLastBalance $pointsBalance )
	{
		$this->error_array = FALSE;
		$this->userDao = $userDao;
		$this->UserAffiliationDao = $userAffiliation;
		$this->userPointsDao =  $usersPoints;
		$this->pointsBalance = $pointsBalance;
		$this->inspiraOfferArray = array( 1 => 561, 
										  2 => 562,
										  3 => 563,
										  4 => 558,
										  5 => 559,
										  6 => 560,
										  7 => 0 );
	}


	public function setTransactionId($transactionId)
	{
		$this->transactionId = $transactionId;
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
// 		print_r($result);
		return $result;
	}


	private function checkApiCall()
	{
		$this->apiResponseJson = $this->doPostToApi();
		$response = json_decode( $this->apiResponseJson);
		$stringResponse = (string)$response->success;
		if(strcasecmp($stringResponse, 'OK')==0)
		{
			$this->apiResponse = TRUE;
			return;
		}
		$this->apiResponse = FALSE;

	}



	public function getApiResponse()
	{
		return $this->apiResponse;
	}


	public function getApiResponseJson()
	{
		return $this->apiResponseJson;
	}



	public function saveToDatabase( $transactionId )
	{

		//if($this->apiResponse)
		//{
			$this->pointsBalance->setUserId( $this->userId );
			$previousBalance = $this->pointsBalance->getCurrentBalance();
			$balanceNow = $previousBalance + $this->pointsToBeAdded;
			$userpoints = array( 'users_id' => $this->userId,
														'transaction_id' => $transactionId,
														'description' => $this->description,
														'added_points' => $this->pointsToBeAdded,
														'substracted_points' => $this->pointsToBeRemoved,
														'balance' => $balanceNow );


			$this->userPointsDao->exchangeArray( $userpoints );
			$this->userPointsDao->save();
			return TRUE;
		//}
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