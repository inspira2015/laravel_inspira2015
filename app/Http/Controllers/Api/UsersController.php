<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Request;
use Redirect;
use Response;
use Session;
use Auth;
use Lang;
use Input;
use App\Model\Dao\UserDao;
use Illuminate\Contracts\Auth\Guard;
use App\Model\Entity\UserRegisteredPhone;

class UsersController extends Controller 
{
	private $userDao;
	protected $auth;
	
	public function __construct(Guard $auth , UserDao $userDao )
	{
		$this->middleware('auth', ['except' => 'exists']);		
		$this->userDao = $userDao;
		$this->auth = $auth;
	}
	
	public function details()
	{
		return Response::json(array(
			'error' => false,
			'data' => $this->auth->user()
		), 200);
	}
	
	public function changeLanguage()
	{
		$this->userDao->load( $this->auth->user()->id );
		$this->userDao->language = $this->auth->user()->language == 'es' ? 'en' : 'es';
		$this->userDao->save();
		
		return Response::json(array(
			'error' => false,
			'redirect' => url('useraccount')
		), 200);
		
	}
	
	public function changeCurrency(){
		$this->userDao->load( $this->auth->user()->id );
		$this->userDao->currency = $this->auth->user()->currency != 'USD' ? 'USD' : 'MXN';
		$this->userDao->save();
		
		
		//Hacer aqui todo el cambio del vacation fund ;)
		
		
		return Response::json(array(
			'error' => false,
			'redirect' => url('useraccount')
		), 200);
	}
	
	public function exists()
	{
		$email = Input::get('email');
		
		$exists = empty($this->userDao->getByEmail( $email )) ? false : true ;	
		$message = '';
		if($exists){
			if( Lang::getLocale() == 'es' ){
				$message ='Ya existe cuenta con esta dirección de correo electrónico.';				
			}else{
				$message ='The email has already been taken.';	
			}
		}
		return Response::json(array(
			'error' => false,
			'data' => array( 'exists' => $exists, 'message' => $message )
		), 200);
	}
}