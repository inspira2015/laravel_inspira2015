<?php 
namespace App\Http\Controllers;
use Request;
use Redirect;
use Input;
use Mail;
use Session;
use URL;
use App\Libraries\Affiliations\ParseCurrencyFromPost;



class VacationfundsController extends Controller 
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
	private $parseAff;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
		$this->parseAff = new ParseCurrencyFromPost();
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function Index()
	{
		if ( !Session::has('users') )
		{			
			return Redirect::to('codes/1');
		}
		$users = Session::get('users');

		if ( !Session::has('affiliation') )
		{			
			return Redirect::to('codes/1');
		}

		$this->parseAff->setAffiliationPost( Session::get( 'affiliation' ) );

		return view('vacationfunds.vacationfund')->with(array('title' =>'Fondo Vacacional',
															  'background' =>'4.jpg',
															   'name' => $users['name'],
															   'currency' => $this->parseAff->getCurrency(),
															   ));
	}



	public function create()
	{
		$post_data = Request::all();
		Session::put('vacationfund',  $post_data );
		print_r( $post_data );
		exit;
		return Redirect::to('vacationfund');
	}


	private function create_user()
	{
		

	}

}
