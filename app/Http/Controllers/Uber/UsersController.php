<?php 
namespace App\Http\Controllers\Uber;
use App\Http\Controllers\Controller;
use App\Libraries\CreateUser\CheckAndSaveUserInfo;
use App\Services\Uber\Register as RegisterValidator;
use Auth;
use Lang;
use Response;
use Request;
use Session;
use Redirect;

class UsersController extends Controller {
	
	public function __construct(Auth $auth ){
		$this->auth = $auth;
		
	}
	
	public function getRegister(){
		if(Auth::check()){
			return redirect('/');
		}
		return view('uber.register')->with('title', 'Reg&iacute;strate')->with('background' , 'register.jpg');
	}
	
	public function postRegister(){
		
		$register = new RegisterValidator();
		$postData = Request::except('_token');
		$validator = $register->validator( $postData, Lang::locale() );

		if($validator->passes()){
			Session::put('user',  $postData );
	//		return "Make magic!";
/*
			$createUser = new CheckAndSaveUserInfo();
			$createUser->setUserPost( $postData );
			$createUser->setCodePost( 'uber' );
			$createUser->setAffiliationPost( 0 );
			$createUser->setVacationFundPost( Session::get( 'vacationfund' ) );
*/
		
/*
			if ( $createUser->saveData()== FALSE )
			{
*/
				//Aqui hacer gurdar el VIIM
				
				
				/*$this->createLeisureUser->setUser( $userAuth );
		$this->createLeisureUser->setTransactionInfo( array('users_id' => $userAuth->id,
																'type' => 'Create Leisure MemberId',
																'description' => 'Create Leisure MemberId',
																'json_data' => ''));
		$this->createLeisureUser->saveData();

*/
//Una vez que se haya enviado el correo mandar, limpiar user data. y hacer authlog.
			return Response::json(array(
				'error' => false,
				'redirect' => url('comprar-certificado')
			), 200);
					
	
		//	}
		}
	/*	This email is already registered. Please log in to activate this certificate to your account or create a new account with this certificate with a different email address

OK*/
		return view('uber.register_form')->withErrors($validator)->with('title', 'Reg&iacute;strate')->with('background' , 'register.jpg');
	}
}