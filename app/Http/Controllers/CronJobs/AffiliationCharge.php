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
use App\Model\Entity\Affiliations;
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

use App\Model\Dao\CodesUsedDao;
use App\Model\Dao\CodeDao;


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
	private $affDao;
	
	public function __construct( 	UserDao $userdao,
									ExchangeRateEntity $exchange,
									UserAffiliation $userAffiliation,
									UserAffiliationPaymentEntity $userAff,
									PrepareTransacionArray $prepareTrans,
									ExchangeMXNUSD $exchangeMXNUSD,
									ChargeUserAffiliation $chargeUserAff,
									AddInspiraPoints $inspiraPoints,
									ChargePoints $sysCharge,
									GetPointsLastBalance $pointsBalance,
									Affiliations $affDao )
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
		$this->affDao = $affDao;

		PayU::$apiKey = "tq4SDejVi5zKlmlw0L78AM4vLf";  //Ingrese aquí su propio apiKey.
		PayU::$apiLogin = "W4Cwmrzwp1e87SZ"; //Ingrese aquí su propio apiLogin.
		PayU::$merchantId = "529182";  //Ingrese aquí su Id de Comercio.
		PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
		PayU::$isTest = FALSE; //Dejarlo True cuando sean pruebas.

		// URL de Pagos
		//Environment::setPaymentsCustomUrl("https://stg.api.payulatam.com/payments-api/4.0/service.cgi");
		Environment::setPaymentsCustomUrl("https://api.payulatam.com/payments-api/4.0/service.cgi");

		// URL de Consultas
		//Environment::setReportsCustomUrl("https://stg.api.payulatam.com/reports-api/4.0/service.cgi");
		Environment::setReportsCustomUrl("https://api.payulatam.com/reports-api/4.0/service.cgi");

		// URL de Suscripciones para Pagos Recurrentes
		//Environment::setSubscriptionsCustomUrl("https://stg.api.payulatam.com/payments-api/rest/v4.3/");
	}


	public function Montlypayment()
	{
		$paymentDays = 0;
		$users = $this->userDao->getUserAffiliatonPayment();
		
		$this->convertHelper->setCurrencyShow( 'MXN' );


		foreach($users as $user)
		{

			if( !$this->userAffiliationPayment->checkPaymentByUserMonth( $user->id, $this->today->month ) )
			{
				exit;
			}
			
			
			
		$this->debugPointsBalance->setUserId($user->id);
		$points = $this->debugPointsBalance->getCurrentBalance();

		$userCurrentAffiliation = $this->userAffiliationDao->getCurrentUserAffiliationByUserId( $user->id );			
			$this->userDao->load($user->id);
			
			$this->userAffiliationDao->load($userCurrentAffiliation->id);
			
			$selectedAffiliation = $this->affDao->getById($userCurrentAffiliation->affiliations_id);
			
			//Get payment type monthly, year, etc.
			$codeUsedDao = new CodesUsedDao();
			$codeDao = new CodeDao();
			
			$codeUsed = $codeUsedDao->getCodesUsedByUserId($user->id);
			
			$payment = $codeDao->getById($codeUsed->codes_id)->payment;
			
			switch($payment){
				case 1: 
					$paymentDays = 30; break;
				case 2: 
					$paymentDays = 365; break;
				default: $paymentDays = 0; break;
			}

			$this->prepareTransactionArray->setUserId( $user->id );
			$this->convertHelper->setCost( $userCurrentAffiliation->amount );
			$this->convertHelper->setCurrencyOfCost( $userCurrentAffiliation->currency );
			$this->prepareTransactionArray->setAccountId( 531038 );
			$this->prepareTransactionArray->setDescription( 'Monthly Affiliation Payment' );
			$this->prepareTransactionArray->setAmount( $this->convertHelper->getFomattedAmount() );
			$this->prepareTransactionArray->setCurrency( 'MXN' );
	
			$parameters = $this->prepareTransactionArray->getParameters();
						echo "<pre>";
			print_r($parameters);
			echo "</pre>";
			exit;
	
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
			    	
					$this->chargeUserAffiliation->setTransactionInfo( array(  'users_id' => $user->id,
																			  'code' => 'DECLINED',
																			  'type' => 'Charge Affiliation',
																			  'description' => $response->transactionResponse->responseCode,
																			  'json_data' => json_encode($response),
																			  'payu_transaction_id' =>$response->transactionResponse->transactionId ));
					$this->chargeUserAffiliation->saveTransaction();
										
					$this->userDao->days_overdue = $this->userDao->days_overdue + 1;
					
					if($this->userDao->days_overdue >= 5){
						$sent = Mail::send('emails.declined', array('user' => $user ), function($message) {	
						$full_name = $user->name . ' ' . $user->last_name;		
				    	$message->to( $user->email, $full_name )
				    			->bcc( Config::get('extra.email.bcc') , $full_name)
				    			->subject( Lang::get('emails.declined-title')."!" );
				    	});
				    	
				    	$this->userDao->active = 0;
				    	
						//Fecha de cobro = Fecha - 5;
						//Cobro atrasado = cobro;
						$charge_at =  Carbon::now()->addDays(($paymentDays-$this->userDao->days_overdue));
			
			exit;
				    	
					}else{
						//fecha = fecha -1
						$this->ChargeUserAffiliation->charge_at = $this->ChargeUserAffiliation->charge_at - 1;
						
					}
					
					$this->userDao->save();
					exit;
			}
			//echo "<br><br>";
			
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

			//Fecha de cargo = fecha de afiliacion(month.week,year) + fecha actual - tries.
			$charge_at = Carbon::now()->addDays(($paymentDays-$this->userDao->days_overdue));			
			$this->userDao->days_overdue = 0;

			$this->inspiraPoints->setDate( date('Y-m-d') );
			$this->inspiraPoints->setUserId( $user->id );
			$this->inspiraPoints->setPoints( $inspiraPoints  );
			$this->inspiraPoints->setReferenceNumber( 'AffiliationPoints' );
			$this->inspiraPoints->setDescription('Points Awarded for monthly Affiliation Payment');
			
			//Agregar puntos

			$this->systemChargePoints->setUser( $user );
			$this->systemChargePoints->setTransactionInfo( array(	'users_id' => $user->id,
																	'code' => 'Success',
																	'type' => 'Charge Affiliation Points',
																	'description' => 'Points Awarded for monthly Affiliation Payment' ));

			$this->systemChargePoints->setAddInspiraPoints( $this->inspiraPoints );
			$this->systemChargePoints->saveData();
			$this->userDao->save();


		}

	
	}
}