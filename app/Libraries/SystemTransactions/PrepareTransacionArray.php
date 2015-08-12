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


	private function generateSession()
	{

	}

	private function generateIPAddress()
	{

	}



	private function builtParameters()
	{
		$parameters = array(
						//Ingrese aquí el identificador de la cuenta.
						PayUParameters::ACCOUNT_ID => $this->storeData['accountId'],
						//Ingrese aquí el código de referencia.
						PayUParameters::REFERENCE_CODE => $this->getRerenceCode(),
						//Ingrese aquí la descripción.
						PayUParameters::DESCRIPTION => $this->storeData['description'],


						// -- Valores --
						//Ingrese aquí el valor.        
						PayUParameters::VALUE => $this->storeData['amount'],
						//Ingrese aquí la moneda.
						PayUParameters::CURRENCY => $this->storeData['currency'],

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


		);
	
	}



	public function getParameters()
	{

	}


}