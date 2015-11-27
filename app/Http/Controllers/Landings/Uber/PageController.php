<?php
namespace App\Http\Controllers\Landings\Uber;
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

use Request;
use Lang;
use Session;

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
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('landings.uber')->with('title', 'Uber' )->with('background','3.jpg');
	}
		
	public function goMazatlan(){
		header('Location: http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid=VIIM1346&targetUri=/resortweeks/quickSearch?saved_search=RoRJln63xXF9SOj');
		exit;
	}
	
	public function goPuertoVallarta(){
		header('Location: http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid=VIIM1346&targetUri=/resortweeks/quickSearch?saved_search=8K8lqf3X6AGnBNx');
		exit;
	}
	
	public function goLasVegas(){
		header('Location: http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid=VIIM1346&targetUri=/resortweeks/quickSearch?saved_search=sfquSB7ODZVEQqs');
		exit;
	}
	
	public function goMalaga(){
		header('Location: http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid=VIIM1346&targetUri=/resortweeks/quickSearch?saved_search=Pe6eaUuRtO8QB0t');
		exit;
	}
	
	public function goDestination(){
		header('Location: http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid=VIIM1346');
		exit;
	}
	
}
