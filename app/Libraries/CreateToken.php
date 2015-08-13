<?php
namespace App\Libraries;
use App\Libraries\InitializePayUCredentials;
use Carbon; 
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


class CreateToken extends InitializePayUCredentials
{

	private $userCreditCard;
	private $authUser;
	private $errorArray;
	private $parameters;
	private $tokenResponse;
	private $paymentMethod;


	public function __construct()
	{
		parent::__construct();
	}


	public function setAuthUser($authUser)
	{
		$this->authUser = $authUser;
	}


	public function setUserCreditCard(array $data)
	{
		$this->userCreditCard = $data;
	}


	private function validatecc()
	{
		if( empty( $this->userCreditCard ) )
		{
			$this->errorArray[] = "Error en la Comunicacion con la pagina, vuelva a Intentar";
			return FALSE;
		}

		if(  $this->cardType( $this->userCreditCard['cnumber'] ) == FALSE )
		{
			$this->errorArray[] = "Error la tarjeta no es soportada intente con Visa o MasterCard";
			return FALSE;
		}

		$this->paymentMethod = $this->cardType( $this->userCreditCard['cnumber'] );
		$parameters = array(
			//Ingrese aquí el nombre del pagador.
			PayUParameters::PAYER_NAME => $this->userCreditCard['name_on_card'],
			//Ingrese aquí el identificador del pagador.
			PayUParameters::PAYER_ID => $this->authUser->id,
			//Ingrese aquí el documento de identificación del comprador.
			PayUParameters::PAYER_DNI => "",
			//Ingrese aquí el número de la tarjeta de crédito
			PayUParameters::CREDIT_CARD_NUMBER => $this->userCreditCard['cnumber'],
			//Ingrese aquí la fecha de vencimiento de la tarjeta de crédito
			PayUParameters::CREDIT_CARD_EXPIRATION_DATE => "{$this->userCreditCard['exp_year']}/{$this->userCreditCard['exp_month']}",
			//Ingrese aquí el nombre de la tarjeta de crédito
			PayUParameters::PAYMENT_METHOD => $this->paymentMethod,
		);
		$this->parameters = $parameters;
		return TRUE;
	}


	private function luhn_check($number) 
	{

		  // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
		  $number=preg_replace('/\D/', '', $number);

		  // Set the string length and parity
		  $number_length=strlen($number);
		  $parity=$number_length % 2;

		  // Loop through each digit and do the maths
		  $total=0;
		  for ($i=0; $i<$number_length; $i++) {
		    $digit=$number[$i];
		    // Multiply alternate digits by two
		    if ($i % 2 == $parity) {
		      $digit*=2;
		      // If the sum is two digits, add them together (in effect)
		      if ($digit > 9) {
		        $digit-=9;
		      }
		    }
		    // Total up the digits
		    $total+=$digit;
		  }

  		// If the total mod 10 equals 0, the number is valid
  		return ($total % 10 == 0) ? TRUE : FALSE;
	}


	private function cardType($number)
	{
	    $number=preg_replace('/[^\d]/','',$number);
	    if (preg_match('/^3[47][0-9]{13}$/',$number))
	    {
	        //return 'American Express';
	        return FALSE;
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

	public function getPaymentMethod()
	{
		return $this->paymentMethod;
	}

	private function checkToken()
	{

		print_r($this->parameters);

   		$response = PayUTokens::create($this->parameters);
		
		if( $response->code == 'SUCCESS' )
		{
			$this->tokenResponse = $response;
			return TRUE;
		}
		else
		{
			$this->errorArray[] = $response->error;
			return FALSE;
		}
	}

	public function checkCreditCardData()
	{
		return $this->validatecc();
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