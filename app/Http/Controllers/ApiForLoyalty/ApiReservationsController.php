<?php
namespace App\Http\Controllers\ApiForLoyalty;
use App\Http\Controllers\Controller;
use App\Services\Api\Reservation as ReservationValidator;
use App\Model\Entity\UserReservationEntity;
use App\Libraries\LeisureLoyaltyUser;
use Request;
use Redirect;
use Response;
use Config;

class ApiReservationsController extends Controller 
{
	private $reservationValidator;
	private $reservationDao;
	private $leisureLoyalty;
	
	public function __construct(ReservationValidator $reservationValidator, UserReservationEntity $reservationEntity, LeisureLoyaltyUser $leisureLoyalty ) {
		$this->reservationValidator = $reservationValidator;
		$this->reservationDao = $reservationEntity;
		$this->leisureLoyalty = $leisureLoyalty;
	}
	public function putReservation(){
		$params = Request::all();
		
		$validator = $this->reservationValidator->validator($params);
		
		if( $validator->passes() ){
			if($params['apiKey'] == Config::get('extra.inspira.apiKey')){
				//Log data logFunction($params['member_id'], 'Added reservation:'.$params['confirmation_code'], 'Api - Reservation code', $post_body);
				
				$this->reservationDao->exchangeArray($params);
				$this->reservationDao->save();
				//mysqli_query($con, "UPDATE codes SET status_date = NOW(), status='Redeem' WHERE status = 'Active' and leisure_id='{$params['member_id']}' and expiration_date > NOW() limit 1");

				////Se le resta una semana de active week, ya que se utilizo una semana.
				
	//			/logFunction($params['member_id'], 'Reedem status code', 'Api - Reservation code');
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