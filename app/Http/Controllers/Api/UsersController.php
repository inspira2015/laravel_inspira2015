<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Request;
use Redirect;
use Response;
use Session;
use Auth;
use App\Model\Dao\UserDao;
use Illuminate\Contracts\Auth\Guard;
use App\Model\Entity\UserRegisteredPhone;

class UsersController extends Controller 
{
	private $userDao;
	protected $auth;
	
	public function __construct(Guard $auth , UserDao $userDao )
	{
		$this->middleware('auth');
		
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
	
	public function test()
	{
		return Response::json(array(
			'error' => false,
			'message' => 'Success api!'
		), 200);
	}
	
	public function changeLanguage(){
		$this->userDao->load( $this->auth->user()->id );
		$this->userDao->language = $this->auth->user()->language == 'es' ? 'en' : 'es';
		$this->userDao->save();
		
		return Response::json(array(
			'error' => false,
			'redirect' => '/useraccount'
		), 200);
	}
}