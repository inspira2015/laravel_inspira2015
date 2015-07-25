<?php 

namespace App\Http\Controllers;
use Auth;
use Request;
use App\Model\Dao\UserDao;
use App\Libraries\Affiliations\CheckCodeAffiliations;
use App\Libraries\Affiliations\AffiliationsColorCodes;
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

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct( UserDao $userDao, 
								 CheckCodeAffiliations $checkAff,
								 Affiliations $affil)
	{
		$this->middleware('guest');
		$this->userDao = $userDao;
		$this->checkAff = $checkAff;
		$this->affiDao = $affil;
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
		$afiliacion = 0;
		if ( Session::has('affiliation') )
		{
			$aff = Session::get('affiliation');
			$afiliacion = $aff['afiliacion'];
		}

		return view('affiliations.affiliation')->with( array( 'title' =>'Affiliaciones',
															  'background' =>'3.jpg',
															  'afiliacion' => $afiliacion,
															  'suscription_array' => $suscription_array,
															  'suscription_count' => $suscription_count,
															  'colorCodes' => new AffiliationsColorCodes() ) );
	}


	public function create()
	{
		$post_data = Request::all();
		Session::put('affiliation',  $post_data );
		return Redirect::to('vacationfund');
	}
	

	

}
