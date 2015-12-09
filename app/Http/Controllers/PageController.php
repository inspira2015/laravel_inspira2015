<?php
namespace App\Http\Controllers;
use Auth;

class PageController extends Controller {

	private $user;
	
	public function __construct(){
		if( Auth::check() ){
			$this->user = Auth::user();
		}
		$this->user->leisure_id = $this->user->leisure_id ? $this->user->leisure_id : 'VIIM1346';
		
	}
	
	public function index()
	{
		return redirect('/');
	}
		
	public function goMazatlan(){
		header('Location: '.$this->autoLogin().'&targetUri=/resortweeks/quickSearch?saved_search=RoRJln63xXF9SOj');
		exit;
	}
	
	public function goPuertoVallarta(){
		header('Location: '.$this->autoLogin().'&targetUri=/resortweeks/quickSearch?saved_search=8K8lqf3X6AGnBNx');
		exit;
	}
	
	public function goLasVegas(){
		header('Location: '.$this->autoLogin().'&targetUri=/resortweeks/quickSearch?saved_search=sfquSB7ODZVEQqs');
		exit;
	}
	
	public function goMalaga(){
		header('Location: '.$this->autoLogin().'&targetUri=/resortweeks/quickSearch?saved_search=Pe6eaUuRtO8QB0t');
		exit;
	}
	
	public function goDestination(){
		header('Location: '.$this->autoLogin());
		exit;
	}
	
	public function goManzanillo(){
		header('Location: '.$this->autoLogin().'&targetUri=/resortweeks/quickSearch?saved_search=EkTqcPm8pWZRZgW');
		exit;
	}
	
	
	private function autoLogin(){
		return "http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid=".$this->user->leisure_id;
	}
}
