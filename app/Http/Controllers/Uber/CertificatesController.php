<?php 
namespace App\Http\Controllers\Uber;
use App\Http\Controllers\Controller;
use App\Services\PaymentMethodCC as PaymentValidator;
use App\Libraries\CardPayment;
use App\Libraries\SystemTransactions\UserTokenRegistration;
use App\Libraries\SystemTransactions\CertificateOperation;
use App\Libraries\LeisureLoyaltyUser;
use Lang;
use Response;
use Session;
use Request;
use Mail;
use Auth;
use Crypt;
use GeoIP;
use Redirect;
use Carbon;
use App\Model\Dao\CountryDao;
use App\Model\Dao\StatesDao;
use App\Model\Dao\UserDao;
use App\Model\Dao\RegisteredCodesDao;
use App\Model\Entity\UserPaymentInfoEntity as UserPayDao;

class CertificatesController extends Controller {

	private $sysTransaction;
	private $leisureLoyalty;
	private $registeredCodeDao;
	private $extend_period = 365;
	
	public function __construct( UserTokenRegistration $sysDao, 
								CertificateOperation $certificateOperation,
								LeisureLoyaltyUser $leisureLoyaltyUser,
								RegisteredCodesDao $registeredCodesDao) {
		$this->sysTransaction = $sysDao;
		$this->certificateOperation = $certificateOperation;
		$this->leisureLoyalty = $leisureLoyaltyUser;
		$this->registeredCodeDao = $registeredCodesDao;
	}
	
	public function getBuyCertificate(){
		if(!Auth::check()) {
			return Redirect::to('registro');
		}

		$usersPayDao = new UserPayDao();
		$payInfo = FALSE;
		if(Auth::check()){
			$payInfo = $usersPayDao->getByUsersId( Auth::user()->id );
		}

		return view('uber.certificates.buy_certificate')->with('cc', $payInfo)
											->with( $this->getCCData() )
											->with('title', 'Comprar certificado' )
											->with('background','beach-girl.jpg');
	}
	
	public function postUseWeek(){
		$user = Auth::user();
		$this->leisureLoyalty->setUser($user);
		$activeDays = $this->timeDiff($this->leisureLoyalty->getExpirationDate(), date('Y-m-d'));
		if( ( count($this->registeredCodeDao->getNotExpired( $user->id )) > 0 && $this->leisureLoyalty->getResortWeeks() > 0) || $activeDays > 0  ){
			return Response::json(array(
				'error' => false,
				'redirect' => 'http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid='.$user->leisure_id
			), 200);
		}else{
			return Response::json(array(
				'error' => false,
				'message' => 'Lo sentimos, su cuenta ha expirado. Favor de agregar certificado o contactarnos en customerservice@inspiramexico.mx.',
				'redirect' => url('/')
			), 200);
		}
	}
	
	
	public function getUseWeek($email = FALSE){
	 	$user = Auth::user();
	 	header("Location: http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid={$user->leisure_id}");	
		exit;
	}
	
	
	
	public function postBuyCertificate(){
		$payment = new PaymentValidator();
		$postData = Request::except('_token');
		$validator = $payment->validator( $postData, Lang::locale() );
		$payment = array('amount' => 45, 'currency' => 'MXN');
		$userAuth = Auth::user();
		if($validator->passes()){
			//Make payment. 
			
			$cardPayment = new CardPayment();
			$location = GeoIP::getLocation();

			$cardPayment->setUserData([
								'full_name' => $userAuth->name. ' '.$userAuth->last_name,
								'id' => $userAuth->id,
								'email' => $userAuth->email,
								'location' => $location['ip']
							]);
			$cardPayment->setAmountData([
								'value' => 45,
								'cnumber' => $postData['cnumber'],
								'expiration_date' => $postData['expiration_date'],
								'currency' => 'MXN',
								'ccv' => $postData['ccv']
							]);
			$cardPayment->setItem([
					'reference' => 'Item-test-'.time(),
					'description' => 'Uber Payment TEST'
			]);
		
			if( $cardPayment->checkPaymentData() )
			{
				
				if( $cardPayment->doToken() ){
					$response = $cardPayment->getToken();
					$responseArray = (array) $response;
					
					if( $cardPayment->getToken()->code == 'SUCCESS' )
					{
						if($cardPayment->getTransactionResponse()->state == 'DECLINED' && $postData['name_on_card'] != 'APPROVED_INSPIRA_CARD'){
							//guardar el mensaje de error de transaccion.
							$this->actionLog( array( 'users_id' => $userAuth->id, 'description' => 'ERROR on Transaction: '.json_encode($cardPayment->getTransactionResponse()), 'method' => 'POST', 'module' => 'Certificate' ) );

							$this->certificateOperation->setUser( $userAuth );
							$this->certificateOperation->setTransactionInfo( array('users_id' => $userAuth->id,
																	'code' => $cardPayment->getTransactionResponse()->state,
																	'type' => 'Register CC Payment Transaction',
																	'description' => $cardPayment->getTransactionResponse()->responseCode,
																	'json_data' => json_encode($responseArray),
																	'amount' => $payment['amount'],
																	'currency' => $payment['currency'],
																	'payu_transaction_id' => $cardPayment->getTransactionId() ) );
							$this->certificateOperation->saveData();								
							//mostrar venana con el error.
							return Response::json(array(
								'error' => false,
								'message' => @$cardPayment->getTransactionResponse()->responseCode,
								'redirect' => url('/comprar-certificado')
							), 200);
						}else{
							$total_active = count($this->registeredCodeDao->getActive( $userAuth->id ));
							//guardar informacion de tarjeta de credito.
							//guardar informacion de transaccion.
							$this->sysTransaction->setUser( $userAuth );
							$this->sysTransaction->setTransactionInfo( array('users_id' => $userAuth->id,
																			'code' => 'Success',
																			'type' => 'Create Token',
																			'description' => 'Create User Token',
																			'json_data' => json_encode(@$responseArray)));
				
							$response_token = @$response->creditCardToken;
							
							$paymentInfo =  array( 'users_id' => $userAuth->id,
											      'token' => @$response_token->creditCardTokenId ? $response_token->creditCardTokenId : '',
											      'ccv' => $postData['ccv'],
											      'name_on_card' => $postData['name_on_card'],
											      'birthdate' => $postData['birthdate'],
											      'payment_method' =>  $cardPayment->getPaymentMethod(),
											      'address' => $postData['address'],
											      'city' => $postData['city'],
											      'state' => $postData['state'],
											      'zip_code' => $postData['zip_code'],
											      'country' => $postData['country']);
				
							$this->sysTransaction->setUserPaymentInfo( $paymentInfo );
							$this->sysTransaction->saveData();
							$this->actionLog( array( 'users_id' => $userAuth->id, 'description' => 'Saved Transaction: '.json_encode($paymentInfo), 'method' => 'POST', 'module' => 'Certificate' ) );


							$this->leisureLoyalty->setUser($userAuth);
							//Agregar codigo a base de datos.
							
							$this->registeredCodeDao->users_id = $userAuth->id;
							$this->registeredCodeDao->code = "UBER";
							$this->registeredCodeDao->status = "Active";
							$this->registeredCodeDao->expiration_date = $this->extend_period;
							$this->registeredCodeDao->save();
							$this->actionLog( array( 'users_id' => $userAuth->id, 'description' => 'Bought Certificate: '.json_encode($this->registeredCodeDao), 'method' => 'POST', 'module' => 'Certificate' ) );

														
							//Si los totales activos es igual a 0.
							if($total_active == 0){
								$this->leisureLoyalty->getUser();
								$leisure_member = json_decode($this->leisureLoyalty->getResponseJson());
								$date = Carbon::now()->addDays($this->registeredCodeDao->expiration_date);
	
								$difference = $this->timeDiff($date, $leisure_member->data->expirationDate );
						
								//Si son muchos dias los divide por anio.
								if($difference > 0){
									$days_in_year = 365;
									$divided_days = ceil($difference/$days_in_year);
									$remainder_days = $difference%$days_in_year;
				
									for($s = 1 ; $s <= $divided_days ; $s++){	
										if($s==$divided_days && $remainder_days > 0){
											$days_requested = $remainder_days;
										}else{
											$days_requested = $days_in_year;
										}
										$this->leisureLoyalty->extend($days_requested);
										$this->actionLog( array( 'users_id' => $userAuth->id, 'description' => 'Extended expiration_date to user:'.$days_requested, 'method' => 'POST', 'module' => 'Certificate' ) );
	
									}
								
								}
							}

							//Hacer request para agregar semana a cuenta (addWeek)
							$this->leisureLoyalty->resortWeek(1);
							$this->actionLog( array( 'users_id' => $userAuth->id, 'description' => 'Added one resort week', 'method' => 'POST', 'module' => 'Certificate' ) );

							//Enviar correo de confirmacion.
							$email_encrypted = $this->encrypt_decrypt('encrypt', $userAuth->email );
							$url = url('usar-semana/'.$email_encrypted );
							$sent = Mail::send('emails.uber.success_payment', array('user' => $userAuth, 'url' => $url ) , function($message) use ($userAuth){
										$full_name = $userAuth['name'] . ' ' . $userAuth->last_name;		
								    	$message->to(  $userAuth->email, $full_name )
								    			->to( 'hp_tanya@hotmail.com' , $full_name)
								    			->subject( "Confirmación de Compra en InspiraMexico"  );
								    	});
							return Response::json(array(
								'error' => false,
								'html' => htmlspecialchars(view('uber.certificates.success_payment')),
								'redirect' => url('http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid='.$userAuth->leisure_id)
							), 200);
						}
					
					}else{
						//guardar el mensaje de error. //transaccion.
						$this->actionLog( array( 'users_id' => $userAuth->id, 'description' => 'ERROR on Transaction: '.json_encode($cardPayment->getTransactionResponse()), 'method' => 'POST', 'module' => 'Certificate' ) );
					}
				}
				
				//guardar el mensaje de error. //transaccion.
				$this->actionLog( array( 'users_id' => $userAuth->id, 'description' => 'ERROR on Transaction: '.json_encode($cardPayment->getErrors()), 'method' => 'POST', 'module' => 'Certificate' ) );

				return view('uber.certificates.buy_certificate_form')->withErrors([$cardPayment->getErrors()[0]])
										->with( $this->getCCData() )
										->with('title', 'Comprar certificado' )
										->with('background','beach-girl.jpg');
				
				
			}	
		}
		$this->actionLog( array( 'users_id' => $userAuth->id, 'description' => 'ERROR on Transaction: '.json_encode($validator), 'method' => 'POST', 'module' => 'Certificate' ) );

		return view('uber.certificates.buy_certificate_form')->withErrors($validator)
											->with( $this->getCCData() )
											->with('title', 'Comprar certificado' )
											->with('background','beach-girl.jpg');
	}
	
	public function newCreditCard(){
		return Response::json(array(
			'error' => false,
			'redirect' => '/comprar-certificado'
		), 200);
	}
	
	public function useCreditCard(){
		$usersPayDao = new UserPayDao();
		$payInfo = $usersPayDao->getByUsersId( Auth::user()->id )->first();
		$data = array(
			'name_on_card' => $payInfo->name_on_card,
			'state' => $payInfo->state,
			'city' => $payInfo->city,
			'zip_code' => $payInfo->zip_code,
			'address' => $payInfo->address,
			'birthdate' => date("Y/m/d", strtotime($payInfo->birthdate))
		);
		return view('uber.certificates.buy_certificate_form')->with($data)
											->with( $this->getCCData() )
											->with('title', 'Comprar certificado' )
											->with('background','beach-girl.jpg');
	}
	
	private function getCCData()
	{
		$locale = Lang::locale();
		return array(  'background' => '2.jpg',
					   'country_list' => $this->getCountryArray($locale),
					   'states' => $this->getStatesArray($locale)
			);
	}
	
	
	protected function getCountryArray($language = FALSE)
	{
		$country = new CountryDao();
		return $country->forSelect('name', 'code');
		
	}
	
	protected function getStatesArray($language = FALSE)
	{
		$states = new StatesDao();
		//default MX - check if its gonna be changed.
		if($language== 'es' || $language==FALSE){
			$country = 'MX';
		}else{
			$country = 'US';
		}
		return $states->forSelect('name', 'code', array('country' => $country ));
	}
}
