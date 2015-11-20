<?php
namespace App\Http\Controllers\ApiForLoyalty;
use App\Http\Controllers\Controller;
use App\Services\Api\Reservation as ReservationValidator;
use App\Model\Entity\UserReservationEntity;
use Request;
use Redirect;
use Response;
use Config;

class ApiReservationsController extends Controller 
{
	private $reservationValidator;
	private $reservationDao;
	
	public function __construct(ReservationValidator $reservationValidator, UserReservationEntity $reservationEntity) {
		$this->reservationValidator = $reservationValidator;
		$this->reservationDao = $reservationEntity;
	}
	public function putReservation(){
		$params = Request::all();
		
		$validator = $this->reservationValidator->validator($params);
		
		if( $validator->passes() ){
			if($params['apiKey'] == Config::get('extra.inspira.apiKey')){
				
				$this->reservationDao->exchangeArray($params);
				$this->reservationDao->save();
				
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
		
		// {"apiKey":"121722689d453a905e02c79477bb79c8", "member_id": "XXXXX", "confirmation_code": "XXXXX", "email_body": "XXXXXXXX" } 
	}
}