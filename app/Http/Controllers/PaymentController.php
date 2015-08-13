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
use App\Model\Entity\UserAffiliation;
use App\Model\Entity\UserVacFundLog;
use App\Model\Dao\CountryDao;
use App\Model\Dao\StatesDao;
use App\Libraries\GeneratePaymentsDates;
use App\Libraries\SystemTransactions\PrepareTransacionArray;
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


	public function __construct( UserTokenRegistration $sysDao,
								SetBillableDate $billable,
								ChargeUserAffiliation $chargeUserAff,
								UserAffiliation $userAff,
								UserVacFundLog $userVacFundLog,
								PrepareTransacionArray $preparePayUArray)
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


		PayU::$apiKey = "6u39nqhq8ftd0hlvnjfs66eh8c"; //Ingrese aquí su propio apiKey.
		PayU::$apiLogin = "11959c415b33d0c"; //Ingrese aquí su propio apiLogin.
		PayU::$merchantId = "500238"; //Ingrese aquí su Id de Comercio.
		PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
		PayU::$isTest = TRUE; //Dejarlo True cuando sean pruebas.

		// URL de Pagos
		Environment::setPaymentsCustomUrl("https://stg.api.payulatam.com/payments-api/4.0/service.cgi");
		// URL de Consultas
		Environment::setReportsCustomUrl("https://stg.api.payulatam.com/reports-api/4.0/service.cgi");
		// URL de Suscripciones para Pagos Recurrentes
		Environment::setSubscriptionsCustomUrl("https://stg.api.payulatam.com/payments-api/rest/v4.3/");
		$this->setLanguage();
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function Index()
	{
        $userAuth = Auth::user();
  	/*	  $hace_ping = PayUPayments::doPing(SupportedLanguages::ES);

 		print_r( $hace_ping );
 		exit;

		$parameters = array(
			//Ingrese aquí el nombre del pagador.
			PayUParameters::PAYER_NAME => "APPROVED",
			//Ingrese aquí el identificador del pagador.
			PayUParameters::PAYER_ID => "150",
			//Ingrese aquí el documento de identificación del comprador.
			PayUParameters::PAYER_DNI => "32144457",
			//Ingrese aquí el número de la tarjeta de crédito
			PayUParameters::CREDIT_CARD_NUMBER => "4111111111111111",
			//Ingrese aquí la fecha de vencimiento de la tarjeta de crédito
			PayUParameters::CREDIT_CARD_EXPIRATION_DATE => "2019/10",
			//Ingrese aquí el nombre de la tarjeta de crédito
			PayUParameters::PAYMENT_METHOD => PaymentMethods::VISA
		);
			
		$response = PayUTokens::create($parameters);   
		print_r($response);
		if($response){
			//podrás obtener el token de la tarjeta
			$response->creditCardToken->creditCardTokenId;
		}

		exit;*/






 /*       $this->prepareTransactionLib->setUserId( $userAuth->id );
        $this->prepareTransactionLib->setAccountId( 500547 );
		$this->prepareTransactionLib->setDescription( 'Test API Validations' );
		$this->prepareTransactionLib->setAmount( 10 );
		$this->prepareTransactionLib->setCurrency( 'MXN' );
		$parameters = $this->prepareTransactionLib->getParameters();
		//print_r($parameters);
		echo "<br><br>";
		//$response = PayUPayments::doAuthorizationAndCapture($parameters);

$reference = "payment_test_00001521";
$value = "100";

		$parameters = array(
			//Ingrese aquí el identificador de la cuenta.
			PayUParameters::ACCOUNT_ID => "500547",
			//Ingrese aquí el código de referencia.
			PayUParameters::REFERENCE_CODE => $reference,
			//Ingrese aquí la descripción.
			PayUParameters::DESCRIPTION => "payment test",
			
			// -- Valores --
			//Ingrese aquí el valor.        
			PayUParameters::VALUE => $value,
			//Ingrese aquí la moneda.
			PayUParameters::CURRENCY => "MXN",
			
			// -- Comprador 
			//Ingrese aquí el nombre del comprador.
			PayUParameters::BUYER_NAME => "First name and second buyer  name",
			//Ingrese aquí el email del comprador.
			PayUParameters::BUYER_EMAIL => "buyer_test@test.com",
			//Ingrese aquí el teléfono de contacto del comprador.
			PayUParameters::BUYER_CONTACT_PHONE => "7563126",
			//Ingrese aquí el documento de contacto del comprador.
			PayUParameters::BUYER_DNI => "5415668464654",
			//Ingrese aquí la dirección del comprador.
			PayUParameters::BUYER_STREET => "Calle Salvador Alvarado",
			PayUParameters::BUYER_STREET_2 => "8 int 103",
			PayUParameters::BUYER_CITY => "Guadalajara",
			PayUParameters::BUYER_STATE => "Jalisco",
			PayUParameters::BUYER_COUNTRY => "MX",
			PayUParameters::BUYER_POSTAL_CODE => "000000",
			PayUParameters::BUYER_PHONE => "7563126",
			
			// -- pagador --
			//Ingrese aquí el nombre del pagador.
			PayUParameters::PAYER_NAME => "First name and second payer name",
			//Ingrese aquí el email del pagador.
			PayUParameters::PAYER_EMAIL => "payer_test@test.com",
			//Ingrese aquí el teléfono de contacto del pagador.
			PayUParameters::PAYER_CONTACT_PHONE => "7563126",
			//Ingrese aquí el documento de contacto del pagador.
			PayUParameters::PAYER_DNI => "5415668464654",
			//OPCIONAL fecha de nacimiento del pagador YYYY-MM-DD, importante para autorización de pagos en México.
			PayUParameters::PAYER_BIRTHDATE => '1980-06-22',

			//Ingrese aquí la dirección del pagador.
			PayUParameters::PAYER_STREET => "Calle Zaragoza esquina",
			PayUParameters::PAYER_STREET_2 => "calle 5 de Mayo",
			PayUParameters::PAYER_CITY => "calle 5 de Mayo",
			PayUParameters::PAYER_STATE => "Nuevo Leon",
			PayUParameters::PAYER_COUNTRY => "MX",
			PayUParameters::PAYER_POSTAL_CODE => "64000",
			PayUParameters::PAYER_PHONE => "7563126",
			
			// DATOS DEL TOKEN
			PayUParameters::TOKEN_ID => "847b4693-d697-4950-84ca-b2fae9efb2ab",
			
			//Ingrese aquí el nombre de la tarjeta de crédito
			//PaymentMethods::VISA||PaymentMethods::MASTERCARD||PaymentMethods::AMEX    
			PayUParameters::PAYMENT_METHOD => PaymentMethods::MASTERCARD,
			
			//Ingrese aquí el número de cuotas.
			PayUParameters::INSTALLMENTS_NUMBER => "1",
			//Ingrese aquí el nombre del pais.
			PayUParameters::COUNTRY => PayUCountries::MX,
			
			//Session id del device.
			PayUParameters::DEVICE_SESSION_ID => "vghs6tvkcle931686k1900o6e1",
			//IP del pagadador
			PayUParameters::IP_ADDRESS => "127.0.0.1",
			//Cookie de la sesión actual.
			PayUParameters::PAYER_COOKIE=>"pt1t38347bs6jc9ruv2ecpv7o2",
			//Cookie de la sesión actual.        
			PayUParameters::USER_AGENT=>"Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
		);
	print_r($parameters);
$response = PayUPayments::doAuthorizationAndCapture($parameters);






		print_r($response);
		exit;*/

		$queryUserAffiliation = $this->userAffiliationDao->getByUsersId( $userAuth->id );
		$userAffiliation = $queryUserAffiliation[0];

		$queryUserVac = $this->userVacationalFundLog->getByUsersId( $userAuth->id );
		$userVacationalFundLog = $queryUserVac[0];

		$this->generatePaymentesDate->setDate( \date('Y-m-d') );


		$data = array(	'title' =>'Resumen',
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


	public function Addcreditcard()
	{
		$paymentMethodCC = new PaymentMethodCC();
		$postData = Request::all();

		print_r($postData );
		exit;



		$validator = $paymentMethodCC->validator( $postData, Lang::locale() );

		
		if ( $validator->passes() ) 
        {
	        $exp_date = explode('/',$postData['expiration_date']);
	        $postData['exp_month'] = $exp_date[1];
	        $postData['exp_year'] = $exp_date[0];
	        array_forget($postData, 'expiration_date');
        	$userAuth = Auth::user();
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
				return view('creditcards.payment_form')->with( $this->getCCData() )->withErrors( $this->createToken->getErrors() )->withInput( $postData );
			}

			if( $this->createToken->doToken() == FALSE ) 
			{
				//Error en tarjeta de credito direccionarlo a pagina
				//Mostrar el mensaje de que dato fallo
				return view('creditcards.payment_form')->with( $this->getCCData() )->withErrors( $this->createToken->getErrors() )->withInput( $postData );
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

			$this->sysTransaction->setUserPaymentInfo( array( 'users_id' => $userAuth->id,
														      'token' => $response_token->creditCardTokenId,
														      'ccv' => $postData['ccv'],
														      'name_on_card' => $postData['name_on_card'],
														      'birthdate' => $postData['birthdate'],
														      'payment_method' => $this->createToken->getPaymentMethod(),
														      'address' => $postData['address'],
														      'city' => $postData['city'],
														      'state' => $postData['state'],
														      'zip_code' => $postData['zip_code'],
														      'country' => $postData['country']));
			$this->sysTransaction->saveData();

			//

			$this->transactionBill->setUser( $userAuth );
			$this->transactionBill->setTransactionInfo( array(	'users_id' => $userAuth->id,
															'code' => 'Success',
															'type' => 'Create Billing Day',
															'description' => 'Add Billing Day to User Account',
															'json_data' => ''));
			$this->transactionBill->saveData();


			$this->chargeUserAffiliation->setUser( $userAuth );
			$this->chargeUserAffiliation->setTransactionInfo( array(	'users_id' => $userAuth->id,
																'code' => 'Success',
																'type' => 'Charge Affiliation',
																'description' => 'Free Month',
																'json_data' => json_encode($responseToStore)));

			$this->chargeUserAffiliation->setAffiliationPayment( array( 'users_id' => $userAuth->id,
																		'charge_at' => date('Y-m-d')));
			
			$this->chargeUserAffiliation->saveData();

			return Response::json(array(
				'error' => false,
				'redirect' => '/useraccount'
			), 200);
        }     
        return view('creditcards.payment_form')->with( $this->getCCData() )->withErrors($validator)->withInput( $postData );
	}


	


	private function getCCData()
	{
		$locale = Lang::locale();
		return array( 'title' => Lang::get('creditcards.title'),
					   'background' => '2.jpg',
					   'monthsList' => $this->getArrayMonths(),
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
