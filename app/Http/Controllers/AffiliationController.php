<?php 

namespace App\Http\Controllers;
use Auth;
use App\Model\Dao\UserDao;

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

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(UserDao $userDao)
	{
		$this->middleware('auth');
		$this->userDao = $userDao;
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function Index()
	{
		// Check User code 
		//echo Auth::user()->id;

		$user = $this->userDao->getUsersCode( Auth::user()->id );
		
		
		print_r($user->code_used()->count());


		exit;
		return view('affiliations.affiliation')->with('title', 'Affiliaciones' )->with('background','3.jpg');
	}
	

	

}
