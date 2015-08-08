<?php 
namespace App\Http\Controllers;
use File;
use App\Libraries\PayU;
use App\Libraries\PayU\api\SupportedLanguages;
use App\Libraries\PayU\api\Environment;
use App\Libraries\PayU\util\PayUParameters;
use App\Libraries\PayU\api\PaymentMethods;
use App\Libraries\PayU\PayUTokens;

//require_once "/var/www/html/laravel_inspira2015/app/Libraries/PayU.php";
//require_once '/var/www/html/laravel_inspira2015/app/Libraries/PayU.php';


class PaymentController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//echo base_path();
		$this->middleware('guest');
		PayU::$apiKey = "6u39nqhq8ftd0hlvnjfs66eh8c"; //Ingrese aquí su propio apiKey.
		PayU::$apiLogin = "11959c415b33d0c"; //Ingrese aquí su propio apiLogin.
		PayU::$merchantId = "500238"; //Ingrese aquí su Id de Comercio.
		PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
		PayU::$isTest = True; //Dejarlo True cuando sean pruebas.
		//StartPayUInspira::setTestEnv();

	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function Index()
	{
		// URL de Pagos
		Environment::setPaymentsCustomUrl("https://stg.api.payulatam.com/payments-api/4.0/service.cgi");
		// URL de Consultas
		Environment::setReportsCustomUrl("https://stg.api.payulatam.com/reports-api/4.0/service.cgi");
		// URL de Suscripciones para Pagos Recurrentes
		Environment::setSubscriptionsCustomUrl("https://stg.api.payulatam.com/payments-api/rest/v4.3/");

		$parameters = array(
			//Ingrese aquí el nombre del pagador.
			PayUParameters::PAYER_NAME => "APPROVED",
			//Ingrese aquí el identificador del pagador.
			PayUParameters::PAYER_ID => "10",
			//Ingrese aquí el documento de identificación del comprador.
			PayUParameters::PAYER_DNI => "32144457",
			//Ingrese aquí el número de la tarjeta de crédito
			PayUParameters::CREDIT_CARD_NUMBER => "4012888888881881",
			//Ingrese aquí la fecha de vencimiento de la tarjeta de crédito
			PayUParameters::CREDIT_CARD_EXPIRATION_DATE => "2017/01",
			//Ingrese aquí el nombre de la tarjeta de crédito
			PayUParameters::PAYMENT_METHOD => PaymentMethods::VISA
		);
	
		$response = PayUTokens::create($parameters);

		print_r($response);
		if($response){
			//podrás obtener el token de la tarjeta
			$response->creditCardToken->creditCardTokenId;
		}


		exit;
		return view('creditcards.creditcard')->with(array('title' =>'Fondo Vacacional',
															 'background' =>'2.jpg'));
	}

	public function Subtotal()
	{

		$parameters = array(
	//Ingrese aquí el nombre del pagador.
	PayUParameters::PAYER_NAME => "full name",
	//Ingrese aquí el identificador del pagador.
	PayUParameters::PAYER_ID => "10",
	//Ingrese aquí el documento de identificación del comprador.
	PayUParameters::PAYER_DNI => "32144457",
	//Ingrese aquí el número de la tarjeta de crédito
	PayUParameters::CREDIT_CARD_NUMBER => "4111111111111111",
	//Ingrese aquí la fecha de vencimiento de la tarjeta de crédito
	PayUParameters::CREDIT_CARD_EXPIRATION_DATE => "2014/10",
	//Ingrese aquí el nombre de la tarjeta de crédito
	PayUParameters::PAYMENT_METHOD => PaymentMethods::VISA
);
	
$response = PayUTokens::create($parameters);   
if($response){
	//podrás obtener el token de la tarjeta
	$response->creditCardToken->creditCardTokenId;
}
		return view('creditcards.subtotal');
	}

	

}
