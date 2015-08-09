<?php 
namespace App\Http\Controllers;
use File;
use App\Libraries\PayU;
use App\Libraries\PayU\api\SupportedLanguages;
use App\Libraries\PayU\api\Environment;
use App\Libraries\PayU\util\PayUParameters;
use App\Libraries\PayU\api\PaymentMethods;
use App\Libraries\PayU\PayUTokens;
use App\Libraries\PayU\api\PayUCountries;
use App\Libraries\PayU\PayUPayments;
use Input;
use Session;
use Request;
use Redirect;


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
		$this->middleware('auth');
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
	

		return view('creditcards.creditcard')->with(array('title' =>'Fondo Vacacional',
															 'background' =>'2.jpg'));
	}


	public function Addcreditcard()
	{
		$postData = Request::all();
		print_r($postData);
		exit;
	}


	public function Subtotal()
	{

		
		return view('creditcards.subtotal')->with(array('title' =>'Resumen',
															 'background' =>'2.jpg'));
	}

	

}
