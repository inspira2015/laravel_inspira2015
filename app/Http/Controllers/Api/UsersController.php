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
//$this->middleware('guest');
		
		$this->userDao = $userDao;
		$this->auth = $auth;
	}
	
	public function details()
	{
		$this->middleware('auth');

		return Response::json(array(
			'error' => false,
			'data' => $this->auth->user()
		), 200);
	}
	
	public function test()
	{
		return Response::json(array(
			'error' => false,
			'message' => 'Success api!'
		), 200);
	}
	
	public function changeLanguage()
	{
		$this->middleware('auth');

		$this->userDao->load( $this->auth->user()->id );
		$this->userDao->language = $this->auth->user()->language == 'es' ? 'en' : 'es';
		$this->userDao->save();
		
		return Response::json(array(
			'error' => false,
			'redirect' => url('useraccount')
		), 200);
		
	}
	
	public function exists()
	{
		$this->middleware('auth');
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