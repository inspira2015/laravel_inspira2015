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


class CashPayment extends InitializePayUCredentials
{

	private $userData;
	private $authUser;
	private $errorArray;
	private $parameters;
	private $tokenResponse;
	private $paymentMethod;
	private $amountData;
	private $itemData;

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


		$this->paymentMethod = PaymentMethods::OXXO;
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
			PayUParameters::PAYER_NAME => $this->userData['full_name'],
			PayUParameters::BUYER_EMAIL => $this->userData['email'],
			//Ingrese aquí el documento de identificación del comprador.
			PayUParameters::PAYER_DNI => "5415668464654",
			
			//Tipo de tienda?
			PayUParameters::PAYMENT_METHOD => PaymentMethods::OXXO,
			//Dependiendo si esta en mexico obvio
			PayUParameters::COUNTRY => PayUCountries::MX,
		//	date('c',time()+259200),
			PayUParameters::EXPIRATION_DATE => date('Y-m-d\TH:i:s',time()+259200),
			PayUParameters::IP_ADDRESS => $this->userData['location']
		);
		$this->parameters = $parameters;
		return TRUE;
	}

	public function checkPaymentData()
	{
		return $this->validatePayment();
	}
	
	public function capture(){
		$response = PayUPayments::doAuthorizationAndCapture($this->parameters);
		

		if($response){
			if(@$response->transactionResponse){
				$response->transactionResponse->orderId;
				$response->transactionResponse->transactionId;
				$response->transactionResponse->state;
				if($response->transactionResponse->state=="PENDING"){
					$response->transactionResponse->pendingReason;
					$response->transactionResponse->extraParameters->URL_PAYMENT_RECEIPT_HTML;
					$response->transactionResponse->extraParameters->REFERENCE;
				}
				$response->transactionResponse->responseCode;
			}		  
		}   

		return $response;
	}

}