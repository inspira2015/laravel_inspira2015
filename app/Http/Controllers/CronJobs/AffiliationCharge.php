<?php

namespace App\Http\Controllers\CronJobs;
use App\Http\Controllers\Controller;
use Carbon; 
use Request;
use Redirect;
use Response;
use Session;
use Auth;
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
	
	public function __construct( 	UserDao $userdao,
									ExchangeRateEntity $exchange,
									UserAffiliation $userAffiliation,
									UserAffiliationPaymentEntity $userAff,
									PrepareTransacionArray $prepareTrans,
									ExchangeMXNUSD $exchangeMXNUSD,
									ChargeUserAffiliation $chargeUserAff )
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

		PayU::$apiKey = "6u39nqhq8ftd0hlvnjfs66eh8c"; //Ingrese aquí su propio apiKey.
		PayU::$apiLogin = "11959c415b33d0c"; //Ingrese aquí su propio apiLogin.
		PayU::$merchantId = "500238"; //Ingrese aquí su Id de Comercio.
		PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
		PayU::$isTest = false; //Dejarlo True cuando sean pruebas.

		// URL de Pagos
		Environment::setPaymentsCustomUrl("https://stg.api.payulatam.com/payments-api/4.0/service.cgi");
		// URL de Consultas
		Environment::setReportsCustomUrl("https://stg.api.payulatam.com/reports-api/4.0/service.cgi");
		// URL de Suscripciones para Pagos Recurrentes
		Environment::setSubscriptionsCustomUrl("https://stg.api.payulatam.com/payments-api/rest/v4.3/");
	}
	

	public function Montlypayment()
	{
		$users = $this->userDao->getUserAffiliatonPayment();
		$this->convertHelper->setCurrencyShow( 'MXN' );

		foreach($users as $user)
		{
			print_r($user->affiliations->amount);
			echo "<br><br>";

			echo $user->id;
			if( $this->userAffiliationPayment->checkPaymentByUserMonth( $user->id, $this->today->month ) )
			{
				continue;
			}

			$this->prepareTransactionArray->setUserId( $user->id );
			$this->convertHelper->setCost( $user->affiliations->amount );
			$this->convertHelper->setCurrencyOfCost( $user->affiliations->currency );
			$this->prepareTransactionArray->setAccountId( 500547 );
			$this->prepareTransactionArray->setDescription( 'Monthly Affiliation Payment' );
			$this->prepareTransactionArray->setAmount( $this->convertHelper->getFomattedAmount() );
			$this->prepareTransactionArray->setCurrency( 'MXN' );
			$parameters = $this->prepareTransactionArray->getParameters();

			$this->chargeUserAffiliation->setUser( $user );

			$response = PayUPayments::doAuthorizationAndCapture($parameters);

			print_r($response);
			echo "<br><br>";


			if( empty($response) )
			{
				$this->chargeUserAffiliation->setTransactionInfo( array(  'users_id' => $user->id,
																		  'code' => 'Error',
																		  'type' => 'Try to charge User Affiliation',
																		  'description' => 'Unexpected Error',
																		  'json_data' => '' ));
				$this->chargeUserAffiliation->saveTransaction();
				continue;
			}


			if ($response->code == 'ERROR') 
			{
				$this->chargeUserAffiliation->setTransactionInfo( array(  'users_id' => $user->id,
																		  'code' => 'Error',
																		  'type' => 'Try to charge User Affiliation',
																		  'description' => $response->error,
																		  'json_data' => json_encode($response) ));
				$this->chargeUserAffiliation->saveTransaction();
				continue;
			}


			if ( $response->transactionResponse->state=="PENDING" ) 
			{
				$this->chargeUserAffiliation->setTransactionInfo( array(  'users_id' => $user->id,
																		  'code' => 'PENDING',
																		  'type' => 'Transaction are Pending to Appy', 
																		  'description' => $response->transactionResponse->responseCode,
																		  'json_data' => json_encode($response),
																		  'payu_transaction_id' =>$response->transactionResponse->transactionId ));
				$this->chargeUserAffiliation->saveTransaction();
				continue;
			}


			if ( $response->transactionResponse->state=="DECLINED" ) 
			{
				$this->chargeUserAffiliation->setTransactionInfo( array(  'users_id' => $user->id,
																		  'code' => 'DECLINED',
																		  'type' => 'Transaction was Declined',
																		  'description' => $response->transactionResponse->responseCode,
																		  'json_data' => json_encode($response),
																		  'payu_transaction_id' =>$response->transactionResponse->transactionId ));
				$this->chargeUserAffiliation->saveTransaction();
				continue;
			}


			$this->chargeUserAffiliation->setTransactionInfo( array(	'users_id' => $userAuth->id,
																		'code' => 'Success',
																		'type' => 'Charge Affiliation',
																		'description' => 'Monthly Affiliation Charge',
																		'json_data' => json_encode($response),
																		'payu_transaction_id' =>$response->transactionResponse->transactionId ));

			$this->chargeUserAffiliation->setAffiliationPayment( array( 'users_id' => $user->id,
																		'charge_at' => date('Y-m-d')));
			
			$this->chargeUserAffiliation->saveData();

		}

	
	}
}