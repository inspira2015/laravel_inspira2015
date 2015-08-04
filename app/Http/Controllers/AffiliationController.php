<?php 

namespace App\Http\Controllers;
use Auth;
use Request;
use App\Model\Dao\UserDao;
use App\Libraries\Affiliations\CheckCodeAffiliations;
use App\Libraries\Affiliations\AffiliationsColorCodes;
use App\Libraries\ExchangeRate\ExchangeMXNUSD;
use App\Libraries\ExchangeRate\ConvertCurrencyHelper;

use App\Model\Entity\Affiliations;
use Lang;
use Session;
use Redirect;


class AffiliationController extends Controller 
{

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


	private $userDao;
	private $checkAff;
	private $affiDao;
	private $exchange;
	private $convertHelper;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct( UserDao $userDao, 
								 CheckCodeAffiliations $checkAff,
								 Affiliations $affil,
								 ExchangeMXNUSD $exchange
								 )
	{
		$this->middleware('guest');
		$this->userDao = $userDao;
		$this->checkAff = $checkAff;
		$this->affiDao = $affil;
		$this->exchange = $exchange;
		$userData = Session::get('users');
		$this->convertHelper = new ConvertCurrencyHelper();
		$this->convertHelper->setCurrencyShow( $userData['currency'] );
		$this->convertHelper->setRateUSDMXN( $this->exchange->getTodayRate() );

	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function Index()
	{
		//$user = $this->userDao->getUsersCode( Auth::user()->id );
		$this->checkAff->setCode( Session::get('code') );
		$suscription_array = $this->checkAff->getAffiliationObjectArray();
		$suscription_count = count( $suscription_array );
		$affiliation = 0;
		if ( Session::has('affiliation') )
		{
			$aff = Session::get('affiliation');
			$affiliation = $aff['affiliation'];
		}

		return view('affiliations.affiliation')->with( array( 'title' =>'Affiliaciones',
															  'background' =>'3.jpg',
															  'affiliation' => $affiliation,
															  'suscription_array' => $suscription_array,
															  'suscription_count' => $suscription_count,
															  'convertHelper' => $this->convertHelper,
															  'colorCodes' => new AffiliationsColorCodes() ) );
	}


	public function create()
	{
		$post_data = Request::all();
		
		if( !isset($post_data['affiliation']) ){
			if( Lang::getLocale() == 'es' ){
				$message = 'Por favor seleccione el tipo de afiliaci&oacute;n.';
			}else{
				$message = 'Please select affiliation type.';
			}
			return Redirect::back()->withErrors(array('message' => $message ));
		}else{
			Session::put('affiliation',  $post_data );
			return Redirect::to('vacationfund');	
		}
	}
	

	

}
