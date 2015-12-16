<?php

namespace App\Http\Controllers\CronJobs;
use App\Http\Controllers\Controller;
use Carbon; 
use Request;
use Redirect;
use Response;
use Session;
use Auth;
use Config;
use App\Model\Entity\ExchangeRateEntity;
use App\Libraries\ApiExchangeRate\CurrentExchangeRate;
use Mail;
use App\Libraries\ExchangeRate\ExchangeMXNUSD;
use App\Libraries\PayU;
use App\Libraries\PayU\api\SupportedLanguages;
use App\Libraries\PayU\api\Environment;
use App\Libraries\PayU\util\PayUParameters;
use App\Libraries\PayU\api\PaymentMethods;
use App\Libraries\PayU\PayUTokens;
use App\Libraries\PayU\api\PayUCountries;
use App\Libraries\PayU\PayUPayments;
use App\Services\PaymentMethodCC as PaymentMethodCC;
use App\Model\Dao\UserDao;
use App\Model\Entity\UserAffiliation;
use App\Model\Entity\UserAffiliationPaymentEntity;
use App\Libraries\SystemTransactions\PrepareTransacionArray;
use App\Libraries\ExchangeRate\ConvertCurrencyHelper;
use App\Libraries\SystemTransactions\ChargeUserAffiliation;
use App\Libraries\SystemTransactions\ChargePoints;
use App\Libraries\GetPointsLastBalance;
use App\Libraries\ConvertMoneyAmountToPoints;
use App\Libraries\AddInspiraPoints;



class AffiliationCharge extends Controller 
{
	private $exchangeDao;
	protected $auth;
	private $currentExchangeRate;
	private $today;
	private $userDao;
	private $userAffiliationPayment;
	private $prepareTransactionArray;
	private $exchange;
	private $chargeUserAffiliation;
	private $convertMoneyToPoints;
	private $inspiraPoints;
	private $systemChargePoints;
	private $userAffiliationDao;
	private $debugPointsBalance;
	
	public function __construct( 	UserDao $userdao,
									ExchangeRateEntity $exchange,
									UserAffiliation $userAffiliation,
									UserAffiliationPaymentEntity $userAff,
									PrepareTransacionArray $prepareTrans,
									ExchangeMXNUSD $exchangeMXNUSD,
									ChargeUserAffiliation $chargeUserAff,
									AddInspiraPoints $inspiraPoints,
									ChargePoints $sysCharge,
									GetPointsLastBalance $pointsBalance )
	{
		$this->middleware('guest');		
		$this->exchangeDao =  $exchange;
		$this->currentExchangeRate = new CurrentExchangeRate();
		$this->today = Carbon::now();
		$this->exchange = $exchangeMXNUSD;
		$this->userDao = $userdao;
		$this->userAffiliationPayment = $userAff;
		$this->prepareTransactionArray = $prepareTrans;
		$this->convertHelper = new ConvertCurrencyHelper();
		$this->convertHelper->setRateUSDMXN( $this->exchange->getTodayRate() );
		$this->chargeUserAffiliation = $chargeUserAff;
		$this->convertMoneyToPoints = new ConvertMoneyAmountToPoints();
		$this->inspiraPoints = $inspiraPoints;
		$this->systemChargePoints = $sysCharge;
		$this->debugPointsBalance = $pointsBalance;
		$this->userAffiliationDao = $userAffiliation;

		PayU::$apiKey = "6u39nqhq8ftd0hlvnjfs66eh8c";  //Ingrese aquí su propio apiKey.
		PayU::$apiLogin = "11959c415b33d0c"; //Ingrese aquí su propio apiLogin.
		PayU::$merchantId = "500238";  //Ingrese aquí su Id de Comercio.
		PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
		PayU::$isTest = TRUE; //Dejarlo True cuando sean pruebas.

		// URL de Pagos
		Environment::setPaymentsCustomUrl("https://stg.api.payulatam.com/payments-api/4.0/service.cgi");
		//Environment::setPaymentsCustomUrl("https://api.payulatam.com/payments-api/4.0/service.cgi");

		// URL de Consultas
		Environment::setReportsCustomUrl("https://stg.api.payulatam.com/reports-api/4.0/service.cgi");
		//Environment::setReportsCustomUrl("https://api.payulatam.com/reports-api/4.0/service.cgi");

		// URL de Suscripciones para Pagos Recurrentes
		//Environment::setSubscriptionsCustomUrl("https://stg.api.payulatam.com/payments-api/rest/v4.3/");
	}


	public function Montlypayment()
	{
		$user = $this->userDao->getUserAffiliatonPaymentTEST();
		$this->convertHelper->setCurrencyShow( 'MXN' );

		//foreach($users as $user)
		//{


			//if( $this->userAffiliationPayment->checkPaymentByUserMonth( $user->id, $this->today->month ) )
		//	{
		//		continue;
		//	}

		//$this->debugPointsBalance->setUserId($user->id);
		//$points = $this->debugPointsBalance->getCurrentBalance();



		$userCurrentAffiliation = $this->userAffiliationDao->getCurrentUserAffiliationByUserId( $user->id );			
			$this->prepareTransactionArray->setUserId( $user->id );
			$this->convertHelper->setCost( $userCurrentAffiliation->amount );
			$this->convertHelper->setCurrencyOfCost( $userCurrentAffiliation->currency );
			$this->prepareTransactionArray->setAccountId( 500547 );
			$this->prepareTransactionArray->setDescription( 'Monthly Affiliation Payment' );
			$this->prepareTransactionArray->setAmount( $this->convertHelper->getFomattedAmount() );
			$this->prepareTransactionArray->setCurrency( 'MXN' );
			$parameters = $this->prepareTransactionArray->getParameters();

			echo "<pre>";
			print_r($parameters);
			echo "<br><br><pre>";

		//	echo $user->id;
			
			if($parameters['value'] == 0){
				echo "Succes";
				$this->chargeUserAffiliation->setTransactionInfo( array(  'users_id' => $user->id,
																		  'code' => 'Success',
																		  'type' => 'Charge Affiliation',
																		  'description' => 'Extend Month',
																		  'amount' => $userCurrentAffiliation->amount,
																		  'currency' => $userCurrentAffiliation->currency,
																		  'json_data' => '' ));
				$this->chargeUserAffiliation->setAffiliationPayment( array( 'users_id' => $user->id,
																		'charge_at' => date('Y-m-d')));
				$this->chargeUserAffiliation->saveTransaction();
			
				exit;
			}
			$this->chargeUserAffiliation->setUser( $user );

			$response = PayUPayments::doAuthorizationAndCapture($parameters);

			print_r($response);
			exit;
			if( empty($response) )
			{
				$this->chargeUserAffiliation->setTransactionInfo( array(  'users_id' => $user->id,
																		  'code' => 'Error',
																		  'type' => 'Charge Affiliation',
																		  'description' => 'Unexpected Error',
																		  'json_data' => '' ));
				$this->chargeUserAffiliation->saveTransaction();
				exit;
			}

			if ($response->code == 'ERROR') 
			{
				$this->chargeUserAffiliation->setTransactionInfo( array(  'users_id' => $user->id,
																		  'code' => 'Error',
																		'type' => 'Charge Affiliation',
																		  'description' => $response->error,
																		  'json_data' => json_encode($response) ));
				$this->chargeUserAffiliation->saveTransaction();
				exit;
			}

			if ( $response->transactionResponse->state=="PENDING" ) 
			{
				$this->chargeUserAffiliation->setTransactionInfo( array(  'users_id' => $user->id,
																		  'code' => 'PENDING',
																		  'type' => 'Charge Affiliation',
																		  'description' => $response->transactionResponse->responseCode,
																		  'json_data' => json_encode($response),
																		  'payu_transaction_id' =>$response->transactionResponse->transactionId ));
				$this->chargeUserAffiliation->saveTransaction();
				exit;
			}

			if ( $response->transactionResponse->state=="DECLINED" ) 
			{
				//Send email.
				$sent = Mail::send('emails.declined', array('user' => $user ), function($message) {	
						$full_name = $user->name . ' ' . $user->last_name;		
				    	$message->to( $user->email, $full_name )
				    			->bcc( Config::get('extra.bcc') , $full_name)
				    			->subject( Lang::get('emails.declined-title')."!" );
				    	});
			    	
					$this->chargeUserAffiliation->setTransactionInfo( array(  'users_id' => $user->id,
																			  'code' => 'DECLINED',
																			  'type' => 'Charge Affiliation',
																			  'description' => $response->transactionResponse->responseCode,
																			  'json_data' => json_encode($response),
																			  'payu_transaction_id' =>$response->transactionResponse->transactionId ));
					$this->chargeUserAffiliation->saveTransaction();
					exit;
					
					//contador de 5.
			}
			echo "<br><br>";
			
			$transactionResponse  = $response->transactionResponse->transactionId;

			$this->chargeUserAffiliation->setTransactionInfo( array(	'users_id' => $user->id,
																		'code' => 'Success',
																		'type' => 'Charge Affiliation',
																		'description' => 'Monthly Affiliation Charge',
																		'json_data' => json_encode($response),
																		'amount' => $userCurrentAffiliation->amount,
																		'currency' => $userCurrentAffiliation->currency,
																		'payu_transaction_id' => $transactionResponse ));

			$this->chargeUserAffiliation->setAffiliationPayment( array( 'users_id' => $user->id,
																		'charge_at' => date('Y-m-d')));
			$this->chargeUserAffiliation->saveData();



			$this->convertMoneyToPoints->setAmount( $userCurrentAffiliation->amount );
			$this->convertMoneyToPoints->setCurrency( $userCurrentAffiliation->currency );
			$inspiraPoints = $this->convertMoneyToPoints->getPoints();

			print_r($inspiraPoints);
			echo "<br><br>";


			$this->inspiraPoints->setDate( date('Y-m-d') );
			$this->inspiraPoints->setUserId( $user->id );
			$this->inspiraPoints->setPoints( $inspiraPoints  );
			$this->inspiraPoints->setReferenceNumber( 'AffiliationPoints' );
			$this->inspiraPoints->setDescription('Points Awarded for monthly Affiliation Payment');



			$this->systemChargePoints->setUser( $user );
			$this->systemChargePoints->setTransactionInfo( array(	'users_id' => $user->id,
																	'code' => 'Success',
																	'type' => 'Charge Affiliation Points',
																	'description' => 'Points Awarded for monthly Affiliation Payment' ));

			$this->systemChargePoints->setAddInspiraPoints( $this->inspiraPoints );
			$this->systemChargePoints->saveData();


		//}

	
	}
}