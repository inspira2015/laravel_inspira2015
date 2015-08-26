<?php 

namespace App\Http\Controllers;
use Auth;
use Request;
use App\Model\Dao\UserDao;
use App\Libraries\Affiliations\CheckCodeAffiliations;
use App\Libraries\Affiliations\AffiliationsColorCodes;
use App\Libraries\ExchangeRate\ExchangeMXNUSD;
use App\Libraries\ExchangeRate\ConvertCurrencyHelper;
use App\Model\Entity\CodesUsedEntity;
use App\Model\Entity\Affiliations;
use Lang;
use Session;
use Redirect;
use App\Libraries\CreateUser\UpdateUserAffiliation;
use App\Model\Entity\UserAffiliation;

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
	private $codesUsedDao;
	private $updateUserAffiliation;
	private $userAffiliationDao;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct( UserDao $userDao, 
								 CheckCodeAffiliations $checkAff,
								 Affiliations $affil,
								 ExchangeMXNUSD $exchange,
								 CodesUsedEntity $codesUsed,
								 UpdateUserAffiliation $updateUser,
								 UserAffiliation $userAff)
	{
		//$this->middleware('guest');
        $this->middleware('auth', ['only' => ['changeaffiliation', 'postcreate']]);

		$this->userDao = $userDao;
		$this->checkAff = $checkAff;
		$this->affiDao = $affil;
		$this->exchange = $exchange;
		$userData = Session::get('users');
		$this->convertHelper = new ConvertCurrencyHelper();
		$this->convertHelper->setCurrencyShow( $userData['currency'] );
		$this->convertHelper->setRateUSDMXN( $this->exchange->getTodayRate() );
		$this->codesUsedDao =  $codesUsed;
		$this->updateUserAffiliation = $updateUser;
		$this->userAffiliationDao = $userAff;
		$this->setLanguage();
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function Index()
	{	
		if ( $this->checkSession() == FALSE )
		{
			return Redirect::to('codes/1');
		}
		$this->checkAff->setCode( Session::get('code') );
		$suscription_array = $this->checkAff->getAffiliationObjectArray();
		$suscription_count = count( $suscription_array );
		$affiliation = 0;
		if ( Session::has('affiliation') )
		{
			$aff = Session::get('affiliation');
			$affiliation = $aff['affiliation'];
		}

		return view('affiliations.affiliation')->with( array( 'title' => Lang::get('affiliations.title'),
															  'background' =>'3.jpg',
															  'affiliation' => $affiliation,
															  'suscription_array' => $suscription_array,
															  'suscription_count' => $suscription_count,
															  'convertHelper' => $this->convertHelper,
															  'exchangeMXN' => $this->exchange->getTodayRate(),
															  'colorCodes' => new AffiliationsColorCodes() ) );
	}


	public function changeaffiliation($userCurrentAffiliation = FALSE)
	{
        $userAuth = Auth::user();
       	Session::put('currentAffiliation',  $userCurrentAffiliation );
        $userAffiliation = $this->userAffiliationDao->getById( $userCurrentAffiliation );
        $usedCodes = $this->codesUsedDao->getCodesUsedByUserId( $userAuth->id );
		$this->checkAff->setCode( $usedCodes->code->code );
		$suscription_array = $this->checkAff->getAffiliationObjectArray();
		$suscription_count = count( $suscription_array );
		return view('affiliations.affiliationchange')->with( array( 'title' => Lang::get('affiliations.title'),
															  'background' =>'3.jpg',
															  'affiliation' => $userAffiliation->affiliations_id,
															  'suscription_array' => $suscription_array,
															  'suscription_count' => $suscription_count,
															  'convertHelper' => $this->convertHelper,
															  'exchangeMXN' => $this->exchange->getTodayRate(),
															  'colorCodes' => new AffiliationsColorCodes() ) );
	}


	public function dochange()
	{
		$userAuth = Auth::user();
		$post_data = Request::all();
		$userCurrentAffiliation = Session::get('currentAffiliation');
		if( !is_numeric( $userCurrentAffiliation ) )
		{
			return Redirect::to('/useraccount');
		}


		$this->updateUserAffiliation->setUserId( $userAuth->id );
		$this->updateUserAffiliation->setAffiliationPost( $post_data );
		$this->updateUserAffiliation->setCurrentAffiliation( $userCurrentAffiliation );
		$this->updateUserAffiliation->changeAffilition();
		Session::forget('currentAffiliation');
		return Redirect::to('/useraccount');

	}


	public function create()
	{
		if ( $this->checkSession() == FALSE )
		{
			return Redirect::to('codes/1');
		}
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
	
	private function checkSession()
	{
		$registrySession = Session::get('registrySession');
		$users = Session::get('users');

		if( empty($registrySession) || empty($users) )
		{
			return FALSE;
		}
		return TRUE;
	}
	

}
