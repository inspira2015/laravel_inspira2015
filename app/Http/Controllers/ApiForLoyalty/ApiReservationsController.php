<?php
namespace App\Http\Controllers\ApiForLoyalty;
use App\Http\Controllers\Controller;
use App\Services\Api\Reservation as ReservationValidator;
use App\Model\Entity\UserReservationEntity;
use App\Libraries\LeisureLoyaltyUser;
use App\Model\Dao\UserDao;
use App\Model\Dao\RegisteredCodesDao;
use Request;
use Redirect;
use Response;
use Config;

class ApiReservationsController extends Controller 
{
	private $reservationValidator;
	private $reservationDao;
	private $leisureLoyalty;
	private $codesDao;
	
	public function __construct(ReservationValidator $reservationValidator, UserReservationEntity $reservationEntity, LeisureLoyaltyUser $leisureLoyalty, UserDao $userDao, RegisteredCodesDao $registeredCodesDao) {
		$this->reservationValidator = $reservationValidator;
		$this->reservationDao = $reservationEntity;
		$this->leisureLoyalty = $leisureLoyalty;
		$this->userDao = $userDao;
		$this->codesDao = $registeredCodesDao;
	}
	public function putReservation(){
		$params = Request::all();
		
		$validator = $this->reservationValidator->validator($params);
		
		if( $validator->passes() ){
			if($params['apiKey'] == Config::get('extra.inspira.apiKey')){
				//Log data logFunction($params['member_id'], 'Added reservation:'.$params['confirmation_code'], 'Api - Reservation code', $post_body);
				$this->reservationDao->exchangeArray($params);
				$user = $this->userDao->getUserByLeisureId($this->reservationDao->leisure_id);
				$code = $this->codesDao->getFirstActive( $user->id );
				if($code){
					//store reservation to table.
					$this->reservationDao->save();
					
					//Cambiar el codigo a Reedem.
					$this->codesDao->load( $code->id );
					$this->codesDao->status = 'Redeem';
					$this->codesDao->save();
					
					//Proceso con api, resta semana.
					$user = $this->userDao->getUserByLeisureId( $this->reservationDao->leisure_id );
					$this->leisureLoyalty->setUser( $user );
					
					//Compara expiration_date con lo que se tiene en api_leisure $this->codesDao->expiration_date
					$this->leisureLoyalty->getUser();
					$leisure_member = json_decode($this->leisureLoyalty->getResponseJson());

					$days_difference = $this->timeDiff($this->codesDao->expiration_date, $leisure_member->data->expirationDate );
					if($days_difference > 0){
						$this->leisureLoyalty->extend( $days_difference );
					}
					
					$this->leisureLoyalty->resortWeek(-1);
				
					return Response::json([
						'response'=> [
							'success' => 'Success',
							'message' => 'Data Saved Correctly'
						]
					],200);
				}else{
					return Response::json([
						'response'=> [
							'success' => 'Error',
							'message' => 'User doesn\'t have any active certificate'
						]
					],200);
				}
				exit;
/*				$this->reservationDao->save();
*/
//Change active, leisure_id, and expiration_date > now() code to reddem.
				
				//mysqli_query($con, "UPDATE codes SET status_date = NOW(), status='Redeem' WHERE status = 'Active' and leisure_id='{$params['member_id']}' and expiration_date > NOW() limit 1");
					//			/logFunction($params['member_id'], 'Reedem status code', 'Api - Reservation code');


				////Se le resta una semana de active week, ya que se utilizo una semana.
/*
				$user = $this->userDao->getUserByLeisureId( $this->reservationDao->leisure_id );
				$this->leisureLoyalty->setUser( $user );
				$this->leisureLoyalty->resortWeek(-1);
*/
				
	
	//logFunction($params['member_id'], 'Removed an active week', 'Api - Reservation code');
	
	//seleccionar el ultimo que se le hizo redeem.
	//comparar fechas. lo que tiene leisure con lo que tenemos en base de datos.
	
	/*$url_send = "https://api.leisureloyalty.com/v3/members/{$params['member_id']}?apiKey=d5tY51ufQX655Ga7Sqs0DjRt8ITTj8vLOHmDJOnuJtBQODpQaa";
	$member = sendGetData($url_send);
	
	$memberArray = json_decode( $member );

	$leisure_expiration = $memberArray->data->expirationDate;
	
	if(!empty($row)){
		$result = mysqli_query($con, "SELECT DATEDIFF('$row[expiration_date]', '$leisure_expiration') as days");
		$row = mysqli_fetch_array($result);
		$days = $row['days'];
	
		if($days > 0 ){
			// y hacer llamada a LL.
			$data = array(
				'days' => $days
	  	 	);
	  	 	
		    $url_send = "https://api.leisureloyalty.com/v3/members/extend/{$params['member_id']}?apiKey=d5tY51ufQX655Ga7Sqs0DjRt8ITTj8vLOHmDJOnuJtBQODpQaa";
		    $result = sendPutData($url_send, json_encode($data));
		    logFunction($params['member_id'], 'Extend expiration date to last active', 'Api - Reservation code');

		}		
	}	*/
/*
			$this->leisureLoyalty->getUser( $this->reservationDao->leisure_id )
			$member = $this->leisureLoyalty->getResponseJson();
			$expiration = $member->data->expirationDate;
			
			//Make comparassion with last redeem.
			if($days > 0){
				$this->leisureLoyalty->extend($days);
				//save it on log 		    logFunction($params['member_id'], 'Extend expiration date to last active', 'Api - Reservation code');

			}
*/
				return Response::json([
					'response'=> [
						'success' => 'Success',
						'message' => 'Data Saved Correctly'
					]
				],200);
				
			}
			$message = 'Incorrect apiKey';
		}else{
			$message = $validator->errors();
		}
		
		return Response::json([
			'response'=> [
				'success' => 'Error',
				'message' => $message
			]
		],200);	
	}
}