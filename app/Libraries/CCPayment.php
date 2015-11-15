<?php
namespace App\Libraries;
use App\Libraries\InitializePayUCredentials;
use Carbon; 
use GeoIP;
use App\Libraries\PayU;
use App\Libraries\PayU\api\SupportedLanguages;
use App\Libraries\PayU\api\Environment;
use App\Libraries\PayU\util\PayUParameters;
use App\Libraries\PayU\api\PaymentMethods;
use App\Libraries\PayU\PayUTokens;
use App\Libraries\PayU\api\PayUCountries;
use App\Libraries\PayU\PayUPayments;

class CCPayment extends InitializePayUCredentials
{

	private $userData;
	private $authUser;
	private $errorArray;
	private $parameters;
	private $tokenResponse;
	private $paymentMethod;
	private $amountData;
	private $itemData;
	private $apiResponse;
	private $storeData;
	private $creditCardData;

	public function __construct()
	{
		parent::__construct();
	}


	public function setUserData($data)
	{
		$this->userData = $data;
	}

	public function setCreditCardData(array $data){
		$this->creditCardData = $data;	
	}

	public function setStoreData( array $data ){
		$this->storeData = $data;	
	}
	
	private function getRerenceCode()
	{
		$descriptionSegment = substr($this->storeData['description'] , 0, 10);
		$amountNoDecimals = (int)$this->storeData['amount'];
		$referenceCode = $this->storeData['userId'] . $descriptionSegment . $amountNoDecimals . $this->storeData['currency'];
		return $referenceCode.time();
	}
	
	private function validatePayment()
	{
		if( empty( $this->userData ) )
		{
			$this->errorArray[] = "No hay suficientes datos de usuario";
			return FALSE;
		}
	



		//$this->paymentMethod = PaymentMethods::OXXO;
//		$payment_method =  $this->getPaymentMethod( $this->itemData['method'] );
		
		$paymentMethod = $this->cardType( $this->creditCardData['cnumber'] );
		$this->paymentMethod = $this->getPaymentMethod( $paymentMethod );

		$buyerFormattedName = $this->userData->name. ' ' . $this->userData->last_name;

		$parameters = array(
				//Ingrese aquí el identificador de la cuenta.
				PayUParameters::ACCOUNT_ID => 500547,
				//Ingrese aquí el código de referencia.
				PayUParameters::REFERENCE_CODE => preg_replace('/\s+/', '', $this->getRerenceCode()),
				//Ingrese aquí la descripción.
				PayUParameters::DESCRIPTION => 'Overdue payment',


				// -- Valores --
				//Ingrese aquí el valor.        
				PayUParameters::VALUE => preg_replace('/[^A-Za-z0-9.\-]/','',$this->storeData['amount']),
				//Ingrese aquí la moneda.
				PayUParameters::CURRENCY => $this->storeData['currency'],

/*
				// -- Comprador 
				//Ingrese aquí el nombre del comprador.
				PayUParameters::BUYER_NAME => $buyerFormattedName,
				//Ingrese aquí el email del comprador.
				PayUParameters::BUYER_EMAIL =>  $this->userData->email,
				//Ingrese aquí el teléfono de contacto del comprador.
				PayUParameters::BUYER_CONTACT_PHONE => $this->userData->phones[0]->number,
				//Ingrese aquí el documento de contacto del comprador.
				PayUParameters::BUYER_DNI => "",
				//Ingrese aquí la dirección del comprador.
				PayUParameters::BUYER_STREET => $this->userData['address'],
				PayUParameters::BUYER_STREET_2 => "",
				PayUParameters::BUYER_CITY => "TIJUANA",
				PayUParameters::BUYER_STATE => "BAJA CALIFORNIA",
				PayUParameters::BUYER_COUNTRY => $this->userData->country,
				PayUParameters::BUYER_POSTAL_CODE => "000000",
				PayUParameters::BUYER_PHONE => $this->userData->phones[0]->number,

				// -- pagador --
				//Ingrese aquí el nombre del pagador.
				PayUParameters::PAYER_NAME => $this->creditCardData['name_on_card'],
				//Ingrese aquí el email del pagador.
				PayUParameters::PAYER_EMAIL => $this->userData->email,
				//Ingrese aquí el teléfono de contacto del pagador.
				PayUParameters::PAYER_CONTACT_PHONE => $this->userData->phones[0]->number,
				//Ingrese aquí el documento de contacto del pagador.
				PayUParameters::PAYER_DNI => "234234234",
				//OPCIONAL fecha de nacimiento del pagador YYYY-MM-DD, importante para autorización de pagos en México.
				PayUParameters::PAYER_BIRTHDATE => $this->userData->birthdate,

				//Ingrese aquí la dirección del pagador.
				PayUParameters::PAYER_STREET => $this->userData->address,
				PayUParameters::PAYER_STREET_2 => $this->userData->address2,
				PayUParameters::PAYER_CITY => $this->userData->city,
				PayUParameters::PAYER_STATE => $this->userData->state,
				PayUParameters::PAYER_COUNTRY => $this->userData->country,
				PayUParameters::PAYER_POSTAL_CODE => $this->userData->zip_code,
				PayUParameters::PAYER_PHONE => $this->userData->phones[0]->number,
				
*/
				// DATOS DEL TOKEN
				PayUParameters::TOKEN_ID => $this->creditCardData['token'],
				PayUParameters::CREDIT_CARD_SECURITY_CODE=> $this->creditCardData['ccv'], 

				//Ingrese aquí el nombre de la tarjeta de crédito
				//PaymentMethods::VISA||PaymentMethods::MASTERCARD||PaymentMethods::AMEX
				PayUParameters::PAYMENT_METHOD => $this->paymentMethod,
				PayUParameters::PAYER_DOCUMENT_TYPE => "CC",
				
				//Ingrese aquí el número de cuotas.
				PayUParameters::INSTALLMENTS_NUMBER => "1",
				//Ingrese aquí el nombre del pais.
				PayUParameters::COUNTRY => $this->creditCardData['country'],
				
				//Session id del device.
				PayUParameters::DEVICE_SESSION_ID => "vghs6tvkcle931686k1900o6e1",
				//IP del pagadador
				PayUParameters::IP_ADDRESS => "127.0.0.1",
				//Cookie de la sesión actual.
				PayUParameters::PAYER_COOKIE=>"pt1t38347bs6jc9ruv2ecpv7o2",
				//Cookie de la sesión actual.        
				PayUParameters::USER_AGENT=>"Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
		);
		
		
		$this->parameters = $parameters;
		print_r($this->parameters);
		return TRUE;
	}

	public function checkPaymentData()
	{
		return $this->validatePayment();
	}
	
	private function checkToken()
	{
   		$this->apiResponse = PayUPayments::doAuthorizationAndCapture($this->parameters);
		print_r($this->apiResponse);
		if( $this->apiResponse->code == 'SUCCESS' )
		{
			$this->tokenResponse = $this->apiResponse;
			return TRUE;
		}
		else
		{
			$this->errorArray[] = $this->apiResponse->error;
			return FALSE;
		}
	}
	
	private function getPaymentMethod( $method_name ){
		switch($method_name){
			case 'AMEX':
				$method = PaymentMethods::AMEX;
				break;
			case 'MASTERCARD':
				$method = PaymentMethods::MASTERCARD;
				break;
			case 'VISA':
				$method = PaymentMethods::VISA;
				break;
		}
		return $method;
	}
	
	private function cardType($number)
	{
	    $number=preg_replace('/[^\d]/','',$number);
	    if (preg_match('/^3[47][0-9]{13}$/',$number))
	    {
	        //return 'American Express';
	        return 'AMEX';
	    }
	    elseif (preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',$number))
	    {
	        //return 'Diners Club';
	        return FALSE;
	    }
	    elseif (preg_match('/^6(?:011|5[0-9][0-9])[0-9]{12}$/',$number))
	    {
	        //return 'Discover';
	        return FALSE;
	    }
	    elseif (preg_match('/^(?:2131|1800|35\d{3})\d{11}$/',$number))
	    {
	        //return 'JCB';
	        return FALSE;
	    }
	    elseif (preg_match('/^5[1-5][0-9]{14}$/',$number))
	    {
	        return 'MASTERCARD';
	    }
	    elseif (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/',$number))
	    {
	        return 'VISA';
	    }
	    else
	    {
	        return FALSE;
	    }
	}

	public function getTransactionId()
	{
		return $this->apiResponse->transactionResponse->transactionId;
	}

	public function getTransactionResponse()
	{
		return $this->getToken()->transactionResponse;
	}
	public function getState(){
		return $this->getTransactionResponse()->state;
	}
	public function getErrors()
	{
		return $this->errorArray;
	}

	public function doToken()
	{
		return $this->checkToken();
	}

	public function getToken()
	{
		return $this->tokenResponse;
	}

}