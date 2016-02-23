<?php
namespace App\Http\Controllers;
use App\Libraries\LeisureLoyaltyUser;
use App\Model\Dao\UserRegisteredPhoneDao as UserRegisteredPhone;
use Auth;

class PageController extends Controller {

	private $user;
	private $leisureUser;
	private $phoneDao;
	private $leisure_id;
	
	public function __construct( LeisureLoyaltyUser $leisureUser, UserRegisteredPhone $registeredPhoneDao ){
		$this->leisureUser = $leisureUser;
		if( Auth::check() ){
			$this->user = Auth::user();
			$this->phoneDao = $registeredPhoneDao;
		}
		$this->leisure_id = isset($this->user->leisure_id) ? $this->user->leisure_id : 'VIIM1346';
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
		if(Auth::check()){
			$authUser = Auth::user();
			$this->leisureUser->setUser( $authUser );
			$phones = new \stdClass();
			$phones->cellphone = $this->phoneDao->findByUserType( $authUser->id, 'cellphone');
			$phones->phone = $this->phoneDao->findByUserType( $authUser->id, 'phone');
			$phones->office = $this->phoneDao->findByUserType( $authUser->id, 'office');
			
			$this->leisureUser->setPhones( $phones );
			$this->leisureUser->updateMember();
		}
		header('Location: '.$this->autoLogin());
		exit;
	}
	
	public function goManzanillo(){
		header('Location: '.$this->autoLogin().'&targetUri=/resortweeks/quickSearch?saved_search=EkTqcPm8pWZRZgW');
		exit;
	}
	
	
	private function autoLogin(){
		return "http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid=".$this->leisure_id;
	}
	
}
