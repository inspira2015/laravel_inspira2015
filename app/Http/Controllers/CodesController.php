<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Validator;

class CodesController extends Controller {

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
		return view('codes.code');
	}
	
	/**
	 * Check if user input a code if its exist or not
	 *
	 * @return Response
	 */
	public function Check(Request $request)
	{
		$post_data = $request->all();

		print_r($post_data);

		$validator = Validator::make($post_data,array('code' => 'required'));

		if($validator->fails())
		{
			echo "fallo";
			exit;
		}

	}

	

}
