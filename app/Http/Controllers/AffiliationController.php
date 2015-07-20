<?php 

namespace App\Http\Controllers;
use Auth;
use App\Model\Dao\UserDao;
use App\Libraries\Affiliations\CheckCodeAffiliations;
use App\Libraries\Affiliations\AffiliationsColorCodes;
use App\Model\Entity\Affiliations;
use Lang;


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
		$this->middleware('auth');
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
		
		$user = $this->userDao->getUsersCode( Auth::user()->id );
		$this->checkAff->setUser( $user );
		$suscription_array = $this->checkAff->getAffiliationObjectArray();
		$suscription_count = count( $suscription_array );

		$data = array(
						'title' =>'Affiliaciones',
						'background' =>'3.jpg',
						'suscription_array' => $suscription_array,
						'suscription_count' => $suscription_count,
						'colorCodes' => new AffiliationsColorCodes()

			);
		return view('affiliations.affiliation')->with( $data );
	}
	

	

}
