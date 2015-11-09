<?php
namespace App\Http\Controllers\Uber;
use App\Http\Controllers\Controller;

use Lang;
use Response;

class LoginController extends Controller {
	public function postLeisureAutologin(){
		return Response::json(array(
			'error' => false,
			'data' => 'Success'
		), 200);
	}
}