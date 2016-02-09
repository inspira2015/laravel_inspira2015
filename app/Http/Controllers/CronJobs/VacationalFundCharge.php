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
use App\Model\Entity\UserVacFundLog;
use App\Libraries\GetLastBalance;
use App\Model\Entity\UserVacationalFunds;
use App\Libraries\SystemTransactions\ChargeVacationalFunds;
use App\Libraries\SystemTransactions\ChargePoints;
use App\Libraries\ConvertMoneyAmountToPoints;
use App\Libraries\AddInspiraPoints;
//UserVacationalFunds


class VacationalFundCharge extends Controller 
{
	private $exchangeDao;
	protected $auth;
	private $currentExchangeRate;
	private $today;
	private $userDao;
	private $prepareTransactionArray;
	private $exchange;
	private $userVacFundLogDao;
	private $lastBalance;
	private $chargeUserVacationalFunds;
	private $inspiraPoints;
	private $systemChargePoints;
	
	public function __construct( 	UserDao $userdao,
									ExchangeRateEntity $exchange,
									UserVacFundLog $userVacFund,
									PrepareTransacionArray $prepareTrans,
									ExchangeMXNUSD $exchangeMXNUSD,
									GetLastBalance $getLast,
									ChargeVacationalFunds $chargeVacationalFunds,
									AddInspiraPoints $inspiraPoints,
									ChargePoints $sysCharge   )
	{
		$this->middleware('guest');		
		$this->exchangeDao =  $exchange;
		$this->currentExchangeRate = new CurrentExchangeRate();
		$this->today = Carbon::now();
		$this->exchange = $exchangeMXNUSD;
		$this->userDao = $userdao;
		$this->userVacFundLogDao = $userVacFund;
	//	$this->userAffiliationPayment = $userAff;UserVacFundLog
		$this->prepareTransactionArray = $prepareTrans;
		$this->convertHelper = new ConvertCurrencyHelper();
		$this->convertHelper->setRateUSDMXN( $this->exchange->getTodayRate() );
		$this->lastBalance = $getLast;
		$this->chargeUserVacationalFunds = $chargeVacationalFunds;
		$this->inspiraPoints = $inspiraPoints;
		$this->systemChargePoints = $sysCharge;
		$this->convertMoneyToPoints = new ConvertMoneyAmountToPoints();



		PayU::$apiKey = "tq4SDejVi5zKlmlw0L78AM4vLf";  //Ingrese aquí su propio apiKey.
		PayU::$apiLogin = "W4Cwmrzwp1e87SZ"; //Ingrese aquí su propio apiLogin.
		PayU::$merchantId = "529182";  //Ingrese aquí su Id de Comercio.
		PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
		PayU::$isTest = TRUE; //Dejarlo True cuando sean pruebas.

		// URL de Pagos
		Environment::setPaymentsCustomUrl("https://stg.api.payulatam.com/payments-api/4.0/service.cgi");
		// URL de Consultas
		Environment::setReportsCustomUrl("https://stg.api.payulatam.com/reports-api/4.0/service.cgi");
		// URL de Suscripciones para Pagos Recurrentes
		Environment::setSubscriptionsCustomUrl("https://stg.api.payulatam.com/payments-api/rest/v4.3/");
	}
	

	public function Montlypayment()
	{
		$user = $this->userDao->getUserAffiliatonPayment();
		$this->convertHelper->setCurrencyShow( 'MXN' );

		//foreach( $users as $user )
		//{
			
			$userVacationalFund = $this->userVacFundLogDao->getCurrentUserVacFundLogByUserId( $user->id );

			$this->prepareTransactionArray->setUserId( $user->id );
			$this->convertHelper->setCost( $userVacationalFund->amount );
			$this->convertHelper->setCurrencyOfCost( $userVacationalFund->currency );
			$this->prepareTransactionArray->setAccountId( 500547 );
			$this->prepareTransactionArray->setDescription( 'Monthly Vacational Fund Payment' );
			$this->prepareTransactionArray->setAmount( $this->convertHelper->getFomattedAmount() );
			$this->prepareTransactionArray->setCurrency( 'MXN' );
			$parameters = $this->prepareTransactionArray->getParameters();
			echo "<pre>";
			print_r( $parameters );
			$this->chargeUserVacationalFunds->setUser( $user );

			$response = PayUPayments::doAuthorizationAndCapture($parameters);

			print_r($response);
			echo "<br><br>";
		
			/*if( empty($response) )
			{
				$this->chargeUserVacationalFunds->setTransactionInfo( array(  'users_id' => $user->id,
																		  'code' => 'Error',
																		  'type' => 'Charge Vacational Fund',
																		  'description' => 'Unexpected Error',
																		  'json_data' => '' ));
				$this->chargeUserVacationalFunds->saveTransaction();
				continue;
			}


			if ($response->code == 'ERROR') 
			{
				$this->chargeUserVacationalFunds->setTransactionInfo( array(  'users_id' => $user->id,
																		  'code' => 'Error',
																		  'type' => 'Charge Vacational Fund',
																		  'description' => $response->error,
																		  'json_data' => json_encode($response) ));
				$this->chargeUserVacationalFunds->saveTransaction();
				continue;
			}
*/

			/*if ( $response->transactionResponse->state=="PENDING" ) 
			{
				$this->chargeUserVacationalFunds->setTransactionInfo( array(  'users_id' => $user->id,
																		  'code' => 'PENDING',
																		  'type' => 'Charge Vacational Fund',
																		  'description' => $response->transactionResponse->responseCode,
																		  'json_data' => json_encode($response),
																		  'payu_transaction_id' =>$response->transactionResponse->transactionId ));
				$this->chargeUserVacationalFunds->saveTransaction();
				continue;
			}


			if ( $response->transactionResponse->state=="DECLINED" ) 
			{
				$this->chargeUserVacationalFunds->setTransactionInfo( array(  'users_id' => $user->id,
																		  'code' => 'DECLINED',
																		  'type' => 'Charge Vacational Fund',
																		  'description' => $response->transactionResponse->responseCode,
																		  'json_data' => json_encode($response),
																		  'payu_transaction_id' =>$response->transactionResponse->transactionId ));
				$this->chargeUserVacationalFunds->saveTransaction();
				continue;
			}*/


			$transactionResponse  = "testVac";      //$response->transactionResponse->transactionId 


			$this->chargeUserVacationalFunds->setTransactionInfo( array(	'users_id' => $user->id,
																		'code' => 'Success',
																		'type' => 'Charge Vacational Fund',
																		'description' => 'Monthly Vacational Fund Charge',
																		'json_data' => json_encode($response),
																		'payu_transaction_id' =>$transactionResponse ));

			$this->chargeUserVacationalFunds->setVacationalFund( array( 'users_id' => $user->id,
																		'charge_at' => date('Y-m-d')));
			
			$this->chargeUserVacationalFunds->saveData();

			$this->convertMoneyToPoints->setAmount( $this->convertHelper->getFomattedAmount() );
			$this->convertMoneyToPoints->setCurrency( $userVacationalFund->currency );
			$inspiraPoints = $this->convertMoneyToPoints->getPoints();


			$this->inspiraPoints->setDate( date('Y-m-d') );
			$this->inspiraPoints->setUserId( $user->id );
			$this->inspiraPoints->setPoints( $inspiraPoints  );
			$this->inspiraPoints->setReferenceNumber( 'VacationalFundPoints' );
			$this->inspiraPoints->setDescription('Points Awarded for monthly Vacational Fund Payment');

			$this->systemChargePoints->setUser( $user );
			$this->systemChargePoints->setTransactionInfo( array(	'users_id' => $user->id,
																	'code' => 'Success',
																	'type' => 'Charge Vacational Funds Points',
																	'description' => 'Points Awarded for monthly Vacational Fund Payment' ));

			$this->systemChargePoints->setAddInspiraPoints( $this->inspiraPoints );
			$this->systemChargePoints->saveData();



		//}


		
	
	}
}