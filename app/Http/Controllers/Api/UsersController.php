<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Request;
use Redirect;
use Response;
use App\Model\Dao\UserDao;
use App\Model\Entity\UserRegisteredPhone;

class UsersController extends Controller {
	private $userDao;
	
	public function __construct( UserDao $userDao ){
		$this->userDao = $userDao;
	}
	
	public function all(){
		return Response::json(array(
			'error' => false,
			'data' => $this->userDao->getAll()
		), 200);
	}
	
	public function test(){
		return Response::json(array(
			'error' => false,
			'message' => 'Success api!'
		), 200);
	}
}