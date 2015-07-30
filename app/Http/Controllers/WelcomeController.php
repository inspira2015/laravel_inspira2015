<?php
namespace App\Http\Controllers;
use App\Model\User;
use App\Model\Affiliations;
use App\Model\UserAffiliations;
use App\Model\Code;
use App\Model\CodesUsed;
use App\Model\SystemLog;
use App\Model\PasswordResets;
use App\Model\UserAddress;
use App\Model\UserRegisteredPhones;
use App\Model\UserVacationalFunds;
use App\Model\VacationFundLog;


class WelcomeController extends Controller {

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
	public function index()
	{
		return view('welcome');
	}
	
	public function terms()
	{
		return view('terms');	
	}

}
