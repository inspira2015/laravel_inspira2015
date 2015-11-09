<?php 
namespace App\Http\Controllers\Uber;
use App\Http\Controllers\Controller;

use Lang;
use Response;
use Request;

use App\Services\Uber\Register as RegisterValidator;

class UsersController extends Controller {
	public function getRegister(){
		return view('uber.register')->with('title', 'Reg&iacute;strate')->with('background' , 'register.jpg');
	}
	
	public function postRegister(){
		
		$register = new RegisterValidator();
		$postData = Request::except('_token');
		$validator = $register->validator( $postData, Lang::locale() );

		if($validator->passes()){
			return "Make magic!";
		}
		return view('uber.register_form')->withErrors($validator)->with('title', 'Reg&iacute;strate')->with('background' , 'register.jpg');
	}
}