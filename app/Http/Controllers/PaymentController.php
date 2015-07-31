<?php 
namespace App\Http\Controllers;

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
		$this->middleware('guest');
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

	public function Subtotal()
	{
		return view('creditcards.subtotal');
	}

	

}
