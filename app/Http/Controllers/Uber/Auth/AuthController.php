<?php
namespace App\Http\Controllers\Uber\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Model\Dao\UserDao;

use Lang;
use Response;
use Request;
use Session;

class AuthController extends Controller {
	private $auth;
	private $userDao;
	public function __construct( Guard $auth,
								UserDao $userdao ){
		$this->middleware('guest', ['except' => 'getLogout']);
		$this->auth = $auth;
		$this->userDao = $userdao;
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
			Session::put('user', true);

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