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

				$this->reservationDao->exchangeArray($params);
				$user = $this->userDao->getUserByLeisureId($this->reservationDao->leisure_id);

				$code = $this->codesDao->getFirstActive( $user->id );
				if($code){
					//store reservation to table.
					$this->reservationDao->save();
					$this->actionLog( array( 'users_id' => $user->id, 'description' => 'Stored reservation:'.json_encode($params), 'method' => 'PUT', 'module' => 'Api - Reservation code' ) );

					//Cambiar el codigo a Reedem.
					$this->codesDao->load( $code->id );
					$this->codesDao->status = 'Redeem';
					$this->codesDao->save();
					$this->actionLog( array( 'users_id' => $user->id, 'description' => 'Active certificate status changed to Redeem', 'method' => 'PUT', 'module' => 'Api - Reservation code' ) );

					//Proceso con api, resta semana.
					$user = $this->userDao->getUserByLeisureId( $this->reservationDao->leisure_id );
					$this->leisureLoyalty->setUser( $user );
					
					//Compara expiration_date con lo que se tiene en api_leisure $this->codesDao->expiration_date
					$this->leisureLoyalty->getUser();
					$leisure_member = json_decode($this->leisureLoyalty->getResponseJson());

					$days_difference = $this->timeDiff($this->codesDao->expiration_date, $leisure_member->data->expirationDate );
					if($days_difference > 0){
						$this->leisureLoyalty->extend( $days_difference );
						$this->actionLog( array( 'users_id' => $user->id, 'description' => 'Extend expiration date to last active', 'method' => 'PUT', 'module' => 'Api - Reservation code' ) );
					}
								
					$this->leisureLoyalty->resortWeek(-1);
					$this->actionLog( array( 'users_id' => $user->id, 'description' => 'Removed an active week', 'method' => 'PUT', 'module' => 'Api - Reservation code' ) );
				
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
				
			}
			$message = 'Incorrect apiKey';
		}else{
			$message = $validator->errors();
			$member = $validator->errors()->get('member_id');

			if($member[0] == 'The selected member id is invalid.'){
				$this->actionLog( array( 'description' => 'Member_id not found:'.$params['member_id'], 'method' => 'PUT', 'module' => 'Api - Reservation code' ) );

			}
		}
		
		return Response::json([
			'response'=> [
				'success' => 'Error',
				'message' => $message
			]
		],200);	
	}
}