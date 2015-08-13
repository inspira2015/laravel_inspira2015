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
		PayU::$apiKey = "tq4SDejVi5zKlmlw0L78AM4vLf"; //Ingrese aquí su propio apiKey.
		PayU::$apiLogin = "W4Cwmrzwp1e87SZ"; //Ingrese aquí su propio apiLogin.
		PayU::$merchantId = "529182"; //Ingrese aquí su Id de Comercio.
		PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
		PayU::$isTest = True; //Dejarlo True cuando sean pruebas.

		// URL de Pagos
		Environment::setPaymentsCustomUrl("https://stg.api.payulatam.com/payments-api/4.0/service.cgi");
		// URL de Consultas
		Environment::setReportsCustomUrl("https://stg.api.payulatam.com/reports-api/4.0/service.cgi");
		// URL de Suscripciones para Pagos Recurrentes
		Environment::setSubscriptionsCustomUrl("https://stg.api.payulatam.com/payments-api/rest/v4.3/");
	}

}