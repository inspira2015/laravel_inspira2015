<?php
namespace App\Http\Controllers\Landings\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Model\Dao\UserDao;
use App\Model\Dao\RegisteredCodesDao;
use App\Libraries\LeisureLoyaltyUser;

use Lang;
use Response;
use Request;
use Session;
use DB;
use Auth;

class AuthController extends Controller {
	private $auth;
	private $userDao;
	private $codesDao; 
	private $leisureLoyalty;
	
	public function __construct( Guard $auth,
								UserDao $userdao,
								LeisureLoyaltyUser $leisureLoyaltyUser,
								RegisteredCodesDao $codeDao){
		$this->middleware('guest', ['except' => 'getLogout']);
		$this->auth = $auth;
		$this->userDao = $userdao;
		$this->codeDao = $codeDao;
		$this->leisureLoyalty = $leisureLoyaltyUser;

	}
	 
	public function postLeisureAutologin(){
		return Response::json(array(
			'error' => false,
			'data' => 'Success'
		), 200);
	}
	
	public function postLogin(){
        $credentials = Request::only('email', 'password');
        $credentials['email'] =  trim($credentials['email']);

		if($this->auth->attempt($credentials)){
			$userAuth = Auth::user();
			$this->leisureLoyalty->setUser( $userAuth );

			$this->actionLog( array( 'users_id' => $userAuth->id, 'description' => 'User Logged', 'method' => 'POST', 'module' => 'Login' ) );

			Session::put('user', true);
			//Revisar los activos.
			$total_active = count($this->codeDao->getActive( $userAuth->id ));

			if($total_active == 0 ){
				$expired = count($this->codeDao->getActiveExpired( $userAuth->id  ));
				//Desactivarlos.
				$this->codeDao->setExpired( $userAuth->id );
				$this->actionLog( array( 'users_id' => $userAuth->id, 'description' => 'Expired active expires codes', 'method' => 'POST', 'module' => 'Login - Total Expires' ) );

				$this->leisureLoyalty->resortWeek(-$expired);
				//quitar en LL.				
				
				//Set expiration date to next date.
				//Comparacion del ultimo con el otro.			
				$last_active = $this->codeDao->getLastActivated( $userAuth->id );
								 				
				if(!empty($last_active)) {
					$this->leisureLoyalty->getUser();
					$member = json_decode( $this->leisureLoyalty->getResponseJson() );
					$leisure_expiration = $member->data->expirationDate;
				
					$days = $this->timeDiff($last_active->expiration_date,$leisure_expiration);
					
					if($days > 0 ){
						$this->leisureLoyalty->extend( $days );
					  	$this->actionLog( array( 'users_id' => $userAuth->id, 'description' => 'Extend expiration date to user'.$days, 'method' => 'POST', 'module' => 'Login - Total Expires' ) );
					}		
				}
			}
			return Response::json(array(
				'error' => false,
				'html' => htmlspecialchars(view('uber.auth.options')),
				'redirect' => url('/')
			), 200);		
		}
		$user = $this->userDao->getUserByEmail(  $credentials['email']  );
	    if($user){
		    return Response::json(array(
				'error' => false,
				'html' => htmlspecialchars(view('uber.auth.login')->withErrors([ 'message' => 'Contrase&ntilde;a Incorrecta'])),
				'redirect' => '/'
			), 200);
		}else{
			return Response::json(array(
				'error' => false,
				'message' =>  "Su correo o contrase&ntilde;a es incorrecto. Favor de intentar de nuevo o contacte al administrador en customerservice@inspiramexico.mx",
				'redirect' => '/'
			), 200);
		}
	}
	
	public function getLogout() {
		Session::forget('user');
        $this->auth->logout();
        return redirect('/');
    }
    
    public function postForgotPassword(){
		return Response::json(array(
			'error' => false,
			'html' => htmlspecialchars(view('uber.auth.forgot_password')),
			'redirect' => '/'
		), 200);
    }
    
    public function postResetPassword(){
	    $email = Request::only('email');
        
	    $user = $this->userDao->getUserByEmail( $email );
	    if($user){
		    return view('uber.auth.forgot_password')->withErrors(['message' => 'Se ha enviado exitosamente el correo. Por favor revise su bandeja.']);
	    }
	    return view('uber.auth.forgot_password')->withErrors(['message' => 'El correo es incorrecto. Favor de intentar de nuevo o contacte al administrador en customerservice@inspiramexico.mx']);
    }
  
}