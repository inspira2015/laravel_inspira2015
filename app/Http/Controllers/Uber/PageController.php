<?php
namespace App\Http\Controllers\Uber;
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
use App\Http\Controllers\Controller;

use Lang;

class PageController extends Controller {

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
		$this->middleware('guest', ['except' => 'index']);
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('uber.main')->with('title', 'Uber' )->with('background','3.jpg');
	}
		
	public function goMazatlan(){
		header('Location: http://inspiramexico.leisureloyalty.com/resortweeks/quickSearch?saved_search=RoRJln63xXF9SOj');
		exit;
	}
	
	public function goPuertoVallarta(){
		header('Location: http://inspiramexico.leisureloyalty.com/resortweeks/quickSearch?rChildren=0&priceTo=&startDate=&minUnitSize=&priceFrom=&doSearch=true&keyword=&rAdults=2&within=60&resortCode=2456,527,938,1972,2358,2463,2659,2672,4105,5121,6671,7717,7831,A870,C251');
		exit;
	}
	
	public function goLasVegas(){
		header('Location: http://inspiramexico.leisureloyalty.com/resortweeks/quickSearch?saved_search=sfquSB7ODZVEQqs');
		exit;
	}
	
	public function goMalaga(){
		header('Location: http://inspiramexico.leisureloyalty.com/resortweeks/quickSearch?saved_search=Pe6eaUuRtO8QB0t');
		exit;
	}
	
	public function goDestination(){
		header('Location: http://inspiramexico.leisureloyalty.com/');
		exit;
	}
	
}
