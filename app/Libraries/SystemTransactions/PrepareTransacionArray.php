<?php
namespace App\Libraries\SystemTransactions;
use App\Model\Dao\UserDao;
use App\Model\Entity\UserPaymentInfoEntity;
use App\Libraries\PayU;
use App\Libraries\PayU\api\Environment;
use App\Libraries\PayU\api\SupportedLanguages;
use App\Libraries\PayU\api\PayUKeyMapName;
use App\Libraries\PayU\api\PayUCommands;
use App\Libraries\PayU\api\PayUTransactionResponseCode;
use App\Libraries\PayU\api\PayUHttpRequestInfo;
use App\Libraries\PayU\api\PayUResponseCode;
use App\Libraries\PayU\api\PayuPaymentMethodType;
use App\Libraries\PayU\api\PaymentMethods;
use App\Libraries\PayU\api\PayUCountries;
use App\Libraries\PayU\exceptions\PayUErrorCodes;
use App\Libraries\PayU\exceptions\PayUException;
use App\Libraries\PayU\exceptions\ConnectionException;
use App\Libraries\PayU\api\PayUConfig;
use App\Libraries\PayU\api\RequestMethod;
use App\Libraries\PayU\util\SignatureUtil;
use App\Libraries\PayU\api\TransactionType;
use App\Libraries\PayU\util\PayURequestObjectUtil;
use App\Libraries\PayU\util\PayUParameters;
use App\Libraries\PayU\util\CommonRequestUtil;
use App\Libraries\PayU\util\RequestPaymentsUtil;
use App\Libraries\PayU\util\UrlResolver;
use App\Libraries\PayU\util\PayUReportsRequestUtil;
use App\Libraries\PayU\util\PayUTokensRequestUtil;
use App\Libraries\PayU\util\PayUSubscriptionsRequestUtil;
use App\Libraries\PayU\util\PayUSubscriptionsUrlResolver;
use App\Libraries\PayU\util\HttpClientUtil;
use App\Libraries\PayU\util\PayUApiServiceUtil;
use App\Libraries\PayU\PayUBankAccounts;
use App\Libraries\PayU\PayUPayments;
use App\Libraries\PayU\PayUReports;
use App\Libraries\PayU\PayUTokens;
use App\Libraries\PayU\PayUSubscriptions;
use App\Libraries\PayU\PayUCustomers;
use App\Libraries\PayU\PayUSubscriptionPlans;
use App\Libraries\PayU\PayUCreditCards;
use App\Libraries\PayU\PayURecurringBill;
use App\Libraries\PayU\PayURecurringBillItem;


class PrepareTransacionArray
{
	
	private $userDao;
	private $userPaymentInfo;
	private $storeData;


	public function __construct(UserDao $userDao,UserPaymentInfoEntity $userPaymentInfo)
	{
		$this->userDao = $userDao;
		$this->userPaymentInfo = $userPaymentInfo;
		$this->storeData = array();
	}

	public function setUserId( $userId )
	{
		$this->storeData['userId'] = $userId;
	}

	public function setAccountId( $accountId )
	{
		$this->storeData['accountId'] = $accountId;
	}


	public function setDescription( $description )
	{
		$this->storeData['description'] = $description;
	}


	public function setAmount( $amount )
	{
		$this->storeData['amount'] = $amount;
	}

	public function setCurrency( $currency )
	{
		$this->storeData['currency'] = $currency;

	}

	private function getRerenceCode()
	{
		$descriptionSegment = substr($this->storeData['description'] , 0, 10);
		$amountNoDecimals = (int)$this->storeData['amount'];
		$referenceCode = $this->storeData['userId'] . $descriptionSegment . $amountNoDecimals . $this->storeData['currency'];
		return $referenceCode;
	}


	public function generateBuyerInfo()
	{
		$user = $this->userDao->getUserPhoneType( $this->storeData['userId'], 'cellphone' );
		if ( empty( $user ) )
		{
			throw new \Exception('Invalid User id or User not Found');
		}
		return $user;
	}

	public function generatePayerInfo()
	{
		$user = $this->userPaymentInfo->getPaymentByUserId( $this->storeData['userId'] );
		return $user[0];
	}

	private function generateSession()
	{

	}

	private function generateIPAddress()
	{

	}



	private function builtParameters()
	{
		$buyerUser = $this->generateBuyerInfo();
		$payerUser = $this->generatePayerInfo();
		$parameters = array(
						//Ingrese aquí el identificador de la cuenta.
						PayUParameters::ACCOUNT_ID => $this->storeData['accountId'],
						//Ingrese aquí el código de referencia.
						PayUParameters::REFERENCE_CODE => preg_replace('/\s+/', '', $this->getRerenceCode()),
						//Ingrese aquí la descripción.
						PayUParameters::DESCRIPTION => $this->storeData['description'],


						// -- Valores --
						//Ingrese aquí el valor.        
						PayUParameters::VALUE => (float)$this->storeData['amount'],
						//Ingrese aquí la moneda.
						PayUParameters::CURRENCY => $this->storeData['currency'],

						// -- Comprador 
						//Ingrese aquí el nombre del comprador.
						PayUParameters::BUYER_NAME => 'APPROVED',
						//Ingrese aquí el email del comprador.
						PayUParameters::BUYER_EMAIL =>  $buyerUser->email,
						//Ingrese aquí el teléfono de contacto del comprador.
						PayUParameters::BUYER_CONTACT_PHONE => $buyerUser->phones[0]->number,
						//Ingrese aquí el documento de contacto del comprador.
						PayUParameters::BUYER_DNI => "5415668464654",
						//Ingrese aquí la dirección del comprador.
						PayUParameters::BUYER_STREET => "",
						PayUParameters::BUYER_STREET_2 => "",
						PayUParameters::BUYER_CITY => "",
						PayUParameters::BUYER_STATE => "",
						PayUParameters::BUYER_COUNTRY => $buyerUser->country,
						PayUParameters::BUYER_POSTAL_CODE => "000000",
						PayUParameters::BUYER_PHONE => $buyerUser->phones[0]->number,

						// -- pagador --
						//Ingrese aquí el nombre del pagador.
						PayUParameters::PAYER_NAME => 'APPROVED',
						//Ingrese aquí el email del pagador.
						PayUParameters::PAYER_EMAIL => $buyerUser->email,
						//Ingrese aquí el teléfono de contacto del pagador.
						PayUParameters::PAYER_CONTACT_PHONE => $buyerUser->phones[0]->number,
						//Ingrese aquí el documento de contacto del pagador.
						PayUParameters::PAYER_DNI => "234234234",
						//OPCIONAL fecha de nacimiento del pagador YYYY-MM-DD, importante para autorización de pagos en México.
						PayUParameters::PAYER_BIRTHDATE => $payerUser->birthdate,

						//Ingrese aquí la dirección del pagador.
						PayUParameters::PAYER_STREET => $payerUser->address,
						PayUParameters::PAYER_STREET_2 => $payerUser->address2,
						PayUParameters::PAYER_CITY => $payerUser->city,
						PayUParameters::PAYER_STATE => $payerUser->state,
						PayUParameters::PAYER_COUNTRY => $payerUser->country,
						PayUParameters::PAYER_POSTAL_CODE => $payerUser->zip_code,
						PayUParameters::PAYER_PHONE => $buyerUser->phones[0]->number,
						
						// DATOS DEL TOKEN
						PayUParameters::TOKEN_ID => $payerUser->token,
						//PayUParameters::CREDIT_CARD_SECURITY_CODE=> $payerUser->ccv, 

						//Ingrese aquí el nombre de la tarjeta de crédito
						//PaymentMethods::VISA||PaymentMethods::MASTERCARD||PaymentMethods::AMEX
						PayUParameters::PAYMENT_METHOD => $payerUser->payment_method,

						
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

	
		return $parameters;
	
	}



	public function getParameters()
	{
		return $this->builtParameters();
	}


}