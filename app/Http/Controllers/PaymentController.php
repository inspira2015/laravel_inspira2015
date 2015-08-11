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
use App\Libraries\CreateToken;
use App\Services\PaymentMethodCC as PaymentMethodCC;
use App\Model\Entity\SystemTransactionEntity;
use App\Libraries\SystemTransactions\UserTokenRegistration;
use Input;
use Session;
use Request;
use Redirect;
use Auth;
use Lang;

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
	private $createToken;
	private $sysTransaction;


	public function __construct(UserTokenRegistration $sysDao)
	{
		//echo base_path();
		$this->middleware('auth');
		$this->sysTransaction = $sysDao;
		$this->createToken = new CreateToken();
		PayU::$apiKey = "6u39nqhq8ftd0hlvnjfs66eh8c"; //Ingrese aquí su propio apiKey.
		PayU::$apiLogin = "11959c415b33d0c"; //Ingrese aquí su propio apiLogin.
		PayU::$merchantId = "500238"; //Ingrese aquí su Id de Comercio.
		PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
		PayU::$isTest = True; //Dejarlo True cuando sean pruebas.

		// URL de Pagos
		Environment::setPaymentsCustomUrl("https://stg.api.payulatam.com/payments-api/4.0/service.cgi");
		// URL de Consultas
		Environment::setReportsCustomUrl("https://stg.api.payulatam.com/reports-api/4.0/service.cgi");
		// URL de Suscripciones para Pagos Recurrentes
		Environment::setSubscriptionsCustomUrl("https://stg.api.payulatam.com/payments-api/rest/v4.3/");
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function Index()
	{

		return view('creditcards.creditcard')->with( $this->getCCData() );
	}


	public function Addcreditcard()
	{
		$postData = Request::all();
		$validator = PaymentMethodCC::validator($postData);


		if ( $validator->passes() ) 
        {
        	$userAuth = Auth::user();
			$this->createToken->setAuthUser( $userAuth  );
			$this->createToken->setUserCreditCard( $postData   );

			/**
			 * Check if Credit Card Info is correct
			 *
			 * @return Boolean
			 */
			if ( $this->createToken->checkCreditCardData() == FALSE )
			{
				//Error en tarjeta de credito direccionarlo a pagina
				//Mostrar el mensaje de que dato fallo
				return Redirect::back()->with( $this->getCCData() )->withErrors( $this->createToken->getErrors() )->withInput( $postData );
			}

			if( $this->createToken->doToken() == FALSE ) 
			{
				//Error en tarjeta de credito direccionarlo a pagina
				//Mostrar el mensaje de que dato fallo
				return Redirect::back()->with( $this->getCCData() )->withErrors( $this->createToken->getErrors() )->withInput( $postData );
			}

			$response = $this->createToken->getToken();
			$responseToStore = (array)$response;

			$this->sysTransaction->setUser( $userAuth );
			$this->sysTransaction->setTransactionInfo( array(	'users_id' => $userAuth->id,
															'code' => 'Success',
															'type' => 'Create Token',
															'description' => 'Create User Token',
															'json_data' => json_encode($responseToStore)));

			$response_token = $response->creditCardToken;

			$this->sysTransaction->setUserPaymentInfo( array( 'users_id' => $userAuth->id,
														      'token' => $response_token->creditCardTokenId,
														      'name_on_card' => $postData['name_on_card'],
														      'payment_method' => '',
														      'address' => $postData['address'],
														      'city' => $postData['city'],
														      'state' => $postData['state'],
														      'zip_code' => $postData['zip_code'],
														      'country' => $postData['country']));

			$this->sysTransaction->saveData();



        }
        $messages = $validator->messages();
        print_r( $messages->all());

        echo "validation err0r";
        exit;
        return Redirect::back()->with( $this->getCCData() )->withErrors($validator)->withInput( $postData );
	}


	public function Subtotal()
	{

		
		return view('creditcards.subtotal')->with(array('title' =>'Resumen',
															 'background' =>'2.jpg'));
	}



	private function getCCData()
	{
		return array( 'title' => Lang::get('creditcards.title'),
					   'background' => '2.jpg',
					   'monthsList' => $this->getArrayMonths(),
					   'yearsList' => $this->getArrayYears(),
			);
	}


	private function getArrayMonths()
	{
		$months[0] = '---Month/Mes----';
		for ($x = 1; $x <= 12; $x++) 
		{
    		$temp = date('m', mktime(0, 0, 0, $x, 1));
			$months[$temp] = $temp;
		}
		return $months;
	}


	private function getArrayYears()
	{
		$currentYear = (int)date("Y");
		$maxYear = $currentYear + 10;
		$years = array();
		$years[0] = '---Year/Ano----';

		for ( $i = $currentYear; $i <= $maxYear; $i++ )
		{
			$years[$i] = $i;
		}

		return $years;
	}
	

}
