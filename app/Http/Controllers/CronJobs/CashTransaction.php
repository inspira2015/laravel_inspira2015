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
use App\Libraries\SystemTransactions\ChargePoints;
use App\Libraries\GetPointsLastBalance;
use App\Libraries\PayU\PayUReports;
use App\Libraries\SystemTransactions\ChargeCashOnVacationalFunds;
use App\Model\Entity\SystemTransactionEntity;
use App\Libraries\ConvertMoneyAmountToPoints;
use App\Libraries\AddInspiraPoints;



class CashTransaction extends Controller 
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

	private $systemTransactionDao;
	private $chargeCashOnVacationalFunds;
	private $debugPointsBalance;
	
	public function __construct( SystemTransactionEntity $systemTransaction,
								 ChargeCashOnVacationalFunds $chargeCash,
								 UserDao $userDao )
	{
		$this->middleware('guest');
		$this->systemTransactionDao = $systemTransaction;
		$this->chargeCashOnVacationalFunds = $chargeCash;
		$this->userDao = $userDao;
		
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
	

	public function Hourlycheck()
	{

		$systemTransaction = $this->systemTransactionDao->getCashTransaction();

		foreach( $systemTransaction as $transaction )
		{
			print_r($user );
			exit;


			if( empty( $transaction->payu_transaction_id ) )
			{
				continue;
			}

			$parameters = array(PayUParameters::TRANSACTION_ID => $transaction->payu_transaction_id);
			$response = PayUReports::getTransactionResponse($parameters);
			
			if ( $response ) 
			{
				switch ($response->state) {
					    case 'APPROVED':
					        $code = 'Success';
					        $type = 'Payment Settled';
							$description = 'The Cash payment has been settled';
					        break;
					    case 'DECLINED':
					    case 'ERROR':
 						case 'EXPIRED':
					    case 'SUBMITTED':
					        $code = 'Error';
							$type = 'Cash Payment Error';
							$description = 'No Cash payment has been settled';
					        break;
 						case 'PENDING':
					        continue;
					        break;
 						
					}

			}
				
			$user = $this->userDao->getById($transaction->users_id);

			$this->chargeCashOnVacationalFunds->setTransactionInfo( array(
											'users_id' => $transaction->users_id,
											'code' => $code,
											'type' => $type,
											'amount' => $transaction->amount,
											'currency' => $transaction->currency,
											'description' => $description,
											'json_data' => json_encode($response),
											'payu_transaction_id' => $transaction->payu_transaction_id
											));

			$this->chargeUserVacationalFunds->setUser( $user );
			$this->chargeUserVacationalFunds->setVacationalFund( array( 'users_id' => $user->id,
																		'charge_at' => date('Y-m-d') ) );
			$this->chargeUserVacationalFunds->saveData();	

				
				print_r($response);

				echo "<br><br>";


		}
		/*exit;
		$parameters = array(PayUParameters::TRANSACTION_ID => "4419624a-e835-4ced-96c4-238fb1b67bdf");

		$response = PayUReports::getTransactionResponse($parameters);

		print_r(	$response );
		exit;

		if ($response) {
			$response->state;
			$response->trazabilityCode;
			$response->authorizationCode;
			$response->responseCode;
			$response->operationDate;
		}*/
		
	
	}
}