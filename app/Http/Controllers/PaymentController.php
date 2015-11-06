<?php 
namespace App\Http\Controllers;
use File;
use App\Libraries\PayU;
use App\Libraries\PayU\api\SupportedLanguages;
use App\Libraries\PayU\api\Environment;
use App\Libraries\PayU\util\PayUParameters;
use App\Libraries\PayU\api\PaymentMethods;
use App\Libraries\PayU\PayUTokens;
use App\Libraries\PayU\api\PayUCountries;
use App\Libraries\PayU\PayUPayments;
use App\Libraries\CreateToken;
use App\Services\PaymentMethodCC as PaymentMethodCC;
use App\Model\Entity\SystemTransactionEntity;
use App\Libraries\SystemTransactions\UserTokenRegistration;
use App\Libraries\SystemTransactions\SetBillableDate;
use App\Libraries\SystemTransactions\ChargeUserAffiliation;
use App\Libraries\CCPayment;
use App\Model\Entity\UserAffiliation;
use App\Model\Entity\UserVacFundLog;
use App\Model\Dao\CountryDao;
use App\Model\Dao\StatesDao;
use App\Model\Dao\UserDao;
use App\Libraries\GeneratePaymentsDates;
use App\Libraries\SystemTransactions\PrepareTransacionArray;
use App\Libraries\SystemTransactions\CreateLeisureUser;
use App\Libraries\AddInspiraPoints;
use App\Libraries\UpdateDataBaseLeisureMember;
use App\Model\Entity\CodesUsedEntity;


use App\Libraries\ExchangeRate\ExchangeMXNUSD;
use App\Libraries\ExchangeRate\ConvertCurrencyHelper;


use App\Libraries\PayU\PayUReports;
use Input;
use Session;
use Request;
use Redirect;
use Auth;
use Lang;
use Response;

class PaymentController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	private $createToken;
	private $sysTransaction;
	private $transactionBill;
	private $chargeUserAffiliation;
	private $userAffiliationDao;
	private $userVacationalFundLog;
	private $generatePaymentesDate;
	private $prepareTransactionLib;
	private $createLeisureUser;
	private $inspiraPoints;
	private $createLeisureUser2;
	private $codesUsedDao;
	private $ccpayment;
	private $exchange;
	private $convertHelper;


	public function __construct( UserTokenRegistration $sysDao,
								SetBillableDate $billable,
								ChargeUserAffiliation $chargeUserAff,
								UserAffiliation $userAff,
								UserVacFundLog $userVacFundLog,
								PrepareTransacionArray $preparePayUArray,
								CreateLeisureUser $createLeisureUser,
								AddInspiraPoints $inspiraPoints,
								CodesUsedEntity $codesUsed,
								CCPayment $ccpayment,
								ExchangeMXNUSD $exchangeMXNUSD)
	{
		//echo base_path();
		$this->middleware('auth');
		$this->sysTransaction = $sysDao;
		$this->createToken = new CreateToken();
		$this->transactionBill = $billable;
		$this->chargeUserAffiliation = $chargeUserAff;
		$this->userAffiliationDao = $userAff;
		$this->userVacationalFundLog = $userVacFundLog;
		$this->generatePaymentesDate = new GeneratePaymentsDates();
		$this->prepareTransactionLib = $preparePayUArray;
		$this->createLeisureUser = $createLeisureUser;
		$this->inspiraPoints = $inspiraPoints;
		$this->codesUsedDao = $codesUsed;
		$this->ccpayment = $ccpayment;
		$this->exchange = $exchangeMXNUSD;
		$this->convertHelper = new ConvertCurrencyHelper();
		$this->convertHelper->setRateUSDMXN( $this->exchange->getTodayRate() );
		$this->setLanguage();


/*
		PayU::$apiKey = "tq4SDejVi5zKlmlw0L78AM4vLf";  //Ingrese aquí su propio apiKey.
		PayU::$apiLogin = "W4Cwmrzwp1e87SZ"; //Ingrese aquí su propio apiLogin.
		PayU::$merchantId = "529182";  //Ingrese aquí su Id de Comercio.
*/

		PayU::$apiKey = "6u39nqhq8ftd0hlvnjfs66eh8c";  //Ingrese aquí su propio apiKey.
		PayU::$apiLogin = "11959c415b33d0c"; //Ingrese aquí su propio apiLogin.
		PayU::$merchantId = "500238";  //Ingrese aquí su Id de Comercio.
		
		PayU::$language = (Lang::locale() == 'es' ) ? SupportedLanguages::ES : SupportedLanguages::EN; //Seleccione el idioma.
		PayU::$isTest = FALSE; //Dejarlo True cuando sean pruebas.

		// URL de Pagos
		Environment::setPaymentsCustomUrl("https://stg.api.payulatam.com/payments-api/4.0/service.cgi");
		//Environment::setPaymentsCustomUrl("https://api.payulatam.com/payments-api/4.0/service.cgi");

		// URL de Consultas
		Environment::setReportsCustomUrl("https://stg.api.payulatam.com/reports-api/4.0/service.cgi");
		//Environment::setReportsCustomUrl("https://api.payulatam.com/reports-api/4.0/service.cgi");

		// URL de Suscripciones para Pagos Recurrentes
		//Environment::setSubscriptionsCustomUrl("https://stg.api.payulatam.com/payments-api/rest/v4.3/");
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function Index()
	{
        $userAuth = Auth::user();

        
		/*$this->createLeisureUser->setUser( $userAuth );
		$this->createLeisureUser->setTransactionInfo( array('users_id' => $userAuth->id,
																'type' => 'Create Leisure MemberId',
																'description' => 'Create Leisure MemberId',
																'json_data' => ''));
		$this->createLeisureUser->saveData();
		exit;*/

		/*$this->inspiraPoints->setDate( date('Y-m-d') );
		$this->inspiraPoints->setUserId( $userAuth->id );
		$this->inspiraPoints->setPoints( 15 );
		$this->inspiraPoints->setReferenceNumber( 'AXTEST25' );
		$this->inspiraPoints->setDescription('TEST');
        $user = $this->inspiraPoints->doPostToApi();
        echo "<pre>";
        $temp = json_decode($user,true);
        print_r($temp);
        exit;*/

		/*$postData[0] = array(
			"id" =>558,
			"memberId" =>'TEST005',
			"memberPoints" => 10,
			"txDateFormat" => "08‐17‐2015",
			"txRefNo" => "ACB123",
			"txNotes" => "TEST ADDING POINTS TO THE USER",

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

		print_r($result);

	$json = file_get_contents('https://api.leisureloyalty.com/v3/rewards?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH&');
		$obj = json_decode($json, true);
	$data= $obj['data'];
		echo "<pre>";
		print_r($data);*/
		//exit;

/*$this->prepareTransactionLib->setUserId( $userAuth->id );
        $this->prepareTransactionLib->setAccountId( 500547 );
		$this->prepareTransactionLib->setDescription( 'Test API Validations' );
		$this->prepareTransactionLib->setAmount( 155 );
		$this->prepareTransactionLib->setCurrency( 'MXN' );
		$parameters = $this->prepareTransactionLib->getParameters();*/


	/*	$postData = array(

			
			"memberFirstName"=> 'gerardo'

		);


		$context = stream_context_create(array(
		    'http' => array(
		        'method' => 'PUT',
		        'header' => "Content-Type: application/json\r\n",
		        'content' => json_encode($postData)
		    )
		));

		$response = file_get_contents('https://api.leisureloyalty.com/v3/members/TEST005?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH&', FALSE, $context);



		if($response === FALSE){
		    die('Error');
		}

		print_r($response);*/
	

		//$responseData = json_decode($response, TRUE);
			//////////////////////////////////////////	UPDATE leisure ID
/*$json = file_get_contents('https://api.leisureloyalty.com/v3/members?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH&');
$obj = json_decode($json, true);
$data= $obj['data'];

echo "<pre>";
foreach($data as $user)
{

	print_r($user);
	echo "<br><br>";


}

exit;*/

	/*	$json = file_get_contents('https://api.leisureloyalty.com/v3/members/TESTUS01?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH&');
		$obj = json_decode($json, true);
		$data= $obj['data'];
		echo "<pre>";
		print_r($data);
		exit;*/



  	 /* $hace_ping = PayUPayments::doPing(SupportedLanguages::ES);

 		print_r( $hace_ping );
 		$user_codes = $this->codesUsedDao->getCodesUsedByUserId( $userAuth->id );

 		 print_r( $user_codes->code->points );

 		exit;*/
 	

		/*$parameters = array(
			//Ingrese aquí el nombre del pagador.
			PayUParameters::PAYER_NAME => "APPROVED",
			//Ingrese aquí el identificador del pagador.
			PayUParameters::PAYER_ID => "150",
			//Ingrese aquí el documento de identificación del comprador.
			PayUParameters::PAYER_DNI => "32144457",
			//Ingrese aquí el número de la tarjeta de crédito
			PayUParameters::CREDIT_CARD_NUMBER => "5323875511207460",
			//Ingrese aquí la fecha de vencimiento de la tarjeta de crédito
			PayUParameters::CREDIT_CARD_EXPIRATION_DATE => "2018/10",
			//Ingrese aquí el nombre de la tarjeta de crédito
			PayUParameters::PAYMENT_METHOD => PaymentMethods::MASTERCARD
		);
			
		$response = PayUTokens::create($parameters);   
		print_r($response);
		if($response){
			//podrás obtener el token de la tarjeta
			$response->creditCardToken->creditCardTokenId;
		}

		exit;*/





		$queryUserAffiliation = $this->userAffiliationDao->getByUsersId( $userAuth->id );
		$userAffiliation = $queryUserAffiliation[0];

		$queryUserVac = $this->userVacationalFundLog->getByUsersId( $userAuth->id );
		$userVacationalFundLog = $queryUserVac[0];

		$this->generatePaymentesDate->setDate( \date('Y-m-d') );


		$data = array(	'title' => Lang::get('subtotal.title') ,
						'background' =>'2.jpg',
						'affiliation_cost' => $userAffiliation->amount,
						'affiliation_currency' => $userAffiliation->currency,
						'vacational_fund_amount' => $userVacationalFundLog->amount,
						'vacational_fund_currency' => $userVacationalFundLog->currency,
						'next_payment_date' => $this->generatePaymentesDate->getNextPaymentDateHumanRead()
			);


		return view('creditcards.subtotal')->with( $data );
	}

	public function Creditcardinfo()
	{
		return view('creditcards.creditcard')->with( $this->getCCData() );
	}

	public function CreditcardinfoUpdate()
	{
		return view('creditcards.changecreditcard')->with( $this->getCCData() );
	}

	public function Addcreditcard()
	{
		$paymentMethodCC = new PaymentMethodCC();
		$postData = Request::except('is_update');

		$validator = $paymentMethodCC->validator( $postData, Lang::locale() );
		
		$blade = 'creditcards.payment_form';

		if(Request::get('is_update')){
			$blade = 'creditcards.payment_form_update';
		}
		
		if ( $validator->passes() ) 
        {
	        
			if (preg_match('/9142017919/', $postData['cnumber'] )){
				
				//Revisar que exista creditcard en fake_credit
				//Si existe revisar los datos hagan match.. 
				
				//si hacen match hacer update en que se usara.
				
				//Guardar informacion en transacccion y agregar los 10,000 pesos/puntos
				
								
				return Response::json(array(
					'error' => false,
						'message' => 'Make process for inspira credit - Inspira Card',
						'redirect' => url('useraccount')
					), 200);
					
				//Si no hace match mandar a pagina de error
				exit;
			}
			$userAuth = Auth::user();

	        $exp_date = explode('/',$postData['expiration_date']);
	        $postData['exp_month'] = $exp_date[1];
	        $postData['exp_year'] = $exp_date[0];
	        array_forget($postData, 'expiration_date');
        	
			$this->createToken->setAuthUser( $userAuth  );
			$this->createToken->setUserCreditCard( $postData   );

			/**
			 * Check if Credit Card Info is correct
			 *
			 * @return Boolean
			 */
			if ( $this->createToken->checkCreditCardData() == FALSE )
			{
				//Error en tarjeta de credito direccionarlo a pagina
				//Mostrar el mensaje de que dato fallo

				return view($blade)->with( $this->getCCData() )->withErrors( $this->createToken->getErrors() )->withInput( $postData );
			}

			if( $this->createToken->doToken() == FALSE ) 
			{
				//Error en tarjeta de credito direccionarlo a pagina
				//Mostrar el mensaje de que dato fallo
				return view($blade)->with( $this->getCCData() )->withErrors( $this->createToken->getErrors() )->withInput( $postData );
			}
			


			$response = $this->createToken->getToken();
			$responseToStore = (array)$response;

			$this->sysTransaction->setUser( $userAuth );
			$this->sysTransaction->setTransactionInfo( array('users_id' => $userAuth->id,
															'code' => 'Success',
															'type' => 'Create Token',
															'description' => 'Create User Token',
															'json_data' => json_encode($responseToStore)));

			$response_token = $response->creditCardToken;
			
			$paymentInfo =  array( 'users_id' => $userAuth->id,
							      'token' => $response_token->creditCardTokenId,
							      'ccv' => $postData['ccv'],
							      'name_on_card' => $postData['name_on_card'],
							      'birthdate' => $postData['birthdate'],
							      'payment_method' => $this->createToken->getPaymentMethod(),
							      'address' => $postData['address'],
							      'city' => $postData['city'],
							      'state' => $postData['state'],
							      'zip_code' => $postData['zip_code'],
							      'country' => $postData['country']);

			$this->sysTransaction->setUserPaymentInfo( $paymentInfo );
			$this->sysTransaction->saveData();

			//

			$this->transactionBill->setUser( $userAuth );
			$this->transactionBill->setTransactionInfo( array(	'users_id' => $userAuth->id,
															'code' => 'Success',
															'type' => 'Create Billing Day',
															'description' => 'Add Billing Day to User Account',
															'json_data' => ''));
			$this->transactionBill->saveData();


/*
			$this->createLeisureUser->setUser( $userAuth );
			$this->createLeisureUser->setTransactionInfo( array('users_id' => $userAuth->id,
																'type' => 'Create Leisure MemberId',
																'description' => 'Create Leisure MemberId',
																'json_data' => ''));
			$this->createLeisureUser->saveData();
*/




			$this->chargeUserAffiliation->setUser( $userAuth );
			$this->chargeUserAffiliation->setTransactionInfo( array(	'users_id' => $userAuth->id,
																'code' => 'Success',
																'type' => 'Charge Affiliation',
																'description' => 'Free Month',
																'json_data' => json_encode($responseToStore)));

			$this->chargeUserAffiliation->setAffiliationPayment( array( 'users_id' => $userAuth->id,
																		'charge_at' => date('Y-m-d')));
			
			$this->chargeUserAffiliation->saveData();

/*
			if($userAuth->days_overdue == 5){

			//	$userDao = new UserDao();
			//	$userDao->load($userAuth->id);

/*
				$userAffDao = new UserAffiliation();
				$userCurrentAffiliation = $userAffDao->getCurrentUserAffiliationByUserId( $userAuth->id  );			
				$this->prepareTransactionArray->setUserId( $userAuth->id );
				$this->convertHelper->setCost( $userCurrentAffiliation->amount );
				$this->convertHelper->setCurrencyOfCost( $userCurrentAffiliation->currency );
*/
						
			//	echo $userCurrentAffiliation->amount;
/*				$aff_amount = 101;
				$aff_currency = 'MXN';
				
				$this->ccpayment->setStoreData( array(
													'userId' => $userAuth->id,
													'description' => 'Overdue affiliation payment',
													'amount' => $aff_amount,
													'currency' => $aff_currency
													)
												);
				$this->ccpayment->setUserData($userAuth);
				$paymentInfo['cnumber'] =  $postData['cnumber'];
				$this->ccpayment->setCreditCardData($paymentInfo);
				$this->ccpayment->checkPaymentData();
				print_r($this->ccpayment->doToken());

				if($this->ccpayment->doToken()){
					if($this->ccpayment->getState() == 'APPROVED'){
						//Aqui van los pasos para que se ponga al corriente la cuenta.
						
						//Save payment and set a new one of last date plus the days_overdue
						
						

						//Get currency and payment
						
						//$userDao->days_overdue = 0;
						//$userDao->save();

						return Response::json(array(
						'error' => false,
						'message' => Lang::get('creditcards.message'),
						'redirect' => url('useraccount')
						), 200);
					}

					return Response::json(array(
						'error' => false,
						'message' => 'DECLINED',
						'redirect' => url('useraccount')
					), 200);
				}else{
					return Response::json(array(
						'error' => false,
						'message' => 'Error on request',
						'redirect' => url('useraccount')
					), 200);
				}
			}
*/
			
			if(!Request::get('is_update')){
				Session::put('complete-profile', 'false');
			}

			return Response::json(array(
				'error' => false,
				'message' => Lang::get('creditcards.message'),
				'redirect' => url('useraccount')
			), 200);
        }     
        return view($blade)->with( $this->getCCData() )->withErrors($validator)->withInput( $postData );
	}
	
	public function getAddCreditCard(){
		 return view('creditcards.creditcard')->with('user' , Auth::user() )->with( $this->getCCData() );
	}
	
	public function bonus(){
		$data = Request::all();
		
		if( $data['type'] == 1 ){
			$blade = 'payment.transfer';
		}else{
			$blade = 'payment.card';
		}
		
		return view($blade)->with('user' , Auth::user() );
	}


	private function getMemberPoints()
	{

	}


	private function getCCData()
	{
		$locale = Lang::locale();
		return array( 'title' => Lang::get('creditcards.title'),
					   'background' => '2.jpg',
					   'monthsList' => $this->getArrayMonths(),
					   'user' => Auth::user(),
					   'yearsList' => $this->getArrayYears(),
					   'country_list' => $this->getCountryArray($locale),
					   'states' => $this->getStatesArray($locale)
			);
	}


	private function getArrayMonths()
	{
		$months[0] = '---Month/Mes----';
		for ($x = 1; $x <= 12; $x++) 
		{
    		$temp = date('m', mktime(0, 0, 0, $x, 1));
			$months[$temp] = $temp;
		}
		return $months;
	}


	private function getArrayYears()
	{
		$currentYear = (int)date("Y");
		$maxYear = $currentYear + 10;
		$years = array();
		$years[0] = '---Year/Ano----';

		for ( $i = $currentYear; $i <= $maxYear; $i++ )
		{
			$years[$i] = $i;
		}

		return $years;
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
