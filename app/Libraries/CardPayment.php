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

/*
	|--------------------------------------------------------------------------
	| Final validataion befor user creation
	|--------------------------------------------------------------------------
	|
	| This library stores a User in to the DB
	| 
	|
*/


class CardPayment extends InitializePayUCredentials
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

	public function __construct()
	{
		parent::__construct();
	}


	public function setUserData(array $data)
	{
		$this->userData = $data;
	}
	
	
	public function setAmountData(array $data){
		$this->amountData = $data;
	}
	
	public function setItem(array $data){
		$this->itemData = $data;
	}


	private function validatePayment()
	{
		if( empty( $this->userData ) )
		{
			$this->errorArray[] = "No hay suficientes datos de usuario";
			return FALSE;
		}

		$paymentMethod = $this->cardType( $this->amountData['cnumber'] );
		$payment_method = $this->getPaymentMethod( $paymentMethod );

		$parameters = array(
			//Ingrese aquí el código de referencia.
			PayUParameters::REFERENCE_CODE => $this->itemData['reference'],
			//Ingrese aquí la descripción.
			PayUParameters::DESCRIPTION => $this->itemData['description'],
			
			// -- Valores --
			//Ingrese aquí el valor.        
			PayUParameters::VALUE => $this->amountData['value'],
			//Ingrese aquí la moneda.
			PayUParameters::CURRENCY => $this->amountData['currency'],

			//Ingrese aquí el nombre del pagador.
			PayUParameters::BUYER_NAME => $this->userData['full_name'],
			PayUParameters::PAYER_NAME => $this->userData['full_name'],
			PayUParameters::BUYER_EMAIL => $this->userData['email'],
			//Ingrese aquí el documento de identificación del comprador.
		//	PayUParameters::PAYER_DNI => "5415668464654",
// 			PayUParameters::PAYER_DOCUMENT_TYPE => "CC",
			PayUParameters::ACCOUNT_ID => 500547,
			//Tipo de tienda?
//			PayUParameters::PAYMENT_METHOD => PaymentMethods::OXXO,


			PayUParameters::INSTALLMENTS_NUMBER => "1",
			PayUParameters::CREDIT_CARD_NUMBER => $this->amountData['cnumber'],
			// Enter expiration date of the credit card here
			PayUParameters::CREDIT_CARD_EXPIRATION_DATE => $this->amountData['expiration_date'],
			//Enter the security code of the credit card here
			PayUParameters::CREDIT_CARD_SECURITY_CODE=> $this->amountData['ccv'],
			//Enter the name of the credit card here
			//PaymentMethods::VISA||PaymentMethods::MASTERCARD||PaymentMethods::AMEX    
			PayUParameters::PAYMENT_METHOD => $payment_method,
			
			//Dependiendo si esta en mexico obvio
			PayUParameters::COUNTRY => PayUCountries::MX,
			
		//	date('c',time()+259200),
			PayUParameters::EXPIRATION_DATE => date('Y-m-d\TH:i:s',time()+259200),
			PayUParameters::IP_ADDRESS => $this->userData['location']
		);
		$this->parameters = $parameters;
		return TRUE;
	}
	
	private function getPaymentMethod( $method_name ){
		switch($method_name){
			case 'VISA':
				$method = PaymentMethods::VISA;
				break;
			case 'AMEX':
				$method = PaymentMethods::AMEX;
				break;
			case 'MASTERCARD':
				$method = PaymentMethods::MASTERCARD;
				break;
			default: 
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

	public function checkPaymentData()
	{
		return $this->validatePayment();
	}
	
	private function checkToken()
	{
   		$this->apiResponse = PayUPayments::doAuthorizationAndCapture($this->parameters);
		
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

	public function getTransactionId()
	{
		return $this->apiResponse->transactionResponse->transactionId;
	}

	public function getTransactionResponse()
	{
		return @$this->getToken()->transactionResponse;
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