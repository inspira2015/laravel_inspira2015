<?php 
namespace App\Http\Controllers;
use Request;
use Redirect;
use Input;
use Mail;
use Session;
use URL;

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

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
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
		return view('vacationfunds.vacationfund')->with(array('title' =>'Fondo Vacacional',
															  'background' =>'4.jpg',
															   'name' => $users['name'],
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
