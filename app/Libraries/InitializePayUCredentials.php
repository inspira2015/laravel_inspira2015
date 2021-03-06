<?php
namespace App\Libraries;
use Carbon; 
use App\Libraries\PayU;
use App\Libraries\PayU\api\SupportedLanguages;
use App\Libraries\PayU\api\Environment;
use App\Libraries\PayU\util\PayUParameters;
use App\Libraries\PayU\api\PaymentMethods;
use App\Libraries\PayU\PayUTokens;
use App\Libraries\PayU\api\PayUCountries;
use App\Libraries\PayU\PayUPayments;
use Lang;
use Config;
/*
	|--------------------------------------------------------------------------
	| Final validataion befor user creation
	|--------------------------------------------------------------------------
	|
	| This library stores a User in to the DB
	| 
	|
*/


class InitializePayUCredentials 
{

	public function __construct()
	{
/*
		PayU::$apiKey = "6u39nqhq8ftd0hlvnjfs66eh8c";  //Ingrese aquí su propio apiKey.
		PayU::$apiLogin = "11959c415b33d0c"; //Ingrese aquí su propio apiLogin.
		PayU::$merchantId = "500238";  //Ingrese aquí su Id de Comercio.
*/
		PayU::$apiKey = Config::get('payu.apiKey');  //Ingrese aquí su propio apiKey.
		PayU::$apiLogin = Config::get('payu.apiLogin'); //Ingrese aquí su propio apiLogin.
		PayU::$merchantId = Config::get('payu.merchantId');  //Ingrese aquí su Id de Comercio.
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

}