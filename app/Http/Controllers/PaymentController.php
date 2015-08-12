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

use Input;
use Session;
use Request;
use Redirect;
use Auth;
use Lang;

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


	public function __construct( UserTokenRegistration $sysDao,
								SetBillableDate $billable,
								ChargeUserAffiliation $chargeUserAff,
								UserAffiliation $userAff,
								UserVacFundLog $userVacFundLog)
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

		PayU::$apiKey = "6u39nqhq8ftd0hlvnjfs66eh8c"; //Ingrese aquí su propio apiKey.
		PayU::$apiLogin = "11959c415b33d0c"; //Ingrese aquí su propio apiLogin.
		PayU::$merchantId = "500238"; //Ingrese aquí su Id de Comercio.
		PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
		PayU::$isTest = True; //Dejarlo True cuando sean pruebas.

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
		$validator = $paymentMethodCC->validator( $postData, Lang::locale() );


		if ( $validator->passes() ) 
        {
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
			$this->sysTransaction->setTransactionInfo( array(	'users_id' => $userAuth->id,
															'code' => 'Success',
															'type' => 'Create Token',
															'description' => 'Create User Token',
															'json_data' => json_encode($responseToStore)));

			$response_token = $response->creditCardToken;

			$this->sysTransaction->setUserPaymentInfo( array( 'users_id' => $userAuth->id,
														      'token' => $response_token->creditCardTokenId,
														      'name_on_card' => $postData['name_on_card'],
														      'payment_method' => '',
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

			return redirect('useraccount');
        }
        $messages = $validator->messages();
       
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
