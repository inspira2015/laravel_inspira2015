<?php 
namespace App\Http\Controllers\Uber;
use App\Http\Controllers\Controller;
use App\Libraries\CreateUser\CheckAndSaveUserInfo;
use App\Services\Uber\Register as RegisterValidator;
use App\Libraries\LeisureLoyaltyUser;
use Illuminate\Contracts\Auth\Guard;
use App\Libraries\SystemTransactions\CreateLeisureUser;
use Auth;
use Lang;
use Mail;
use Response;
use Request;
use Session;
use Redirect;

class UsersController extends Controller {
	private $createUser;
	private $guard;
	private $createLeisureUser;
	private $auth;
	private $leisureLoyalty;
	public function __construct(Auth $auth, CheckAndSaveUserInfo $checkUser, Guard $guard, CreateLeisureUser $createLeisureUser, LeisureLoyaltyUser $leisureLoyaltyUser){
		$this->auth = $auth;
		$this->guard  = $guard;
		$this->createUser = $checkUser;
		$this->createLeisureUser = $createLeisureUser;
		$this->leisureLoyalty = $leisureLoyaltyUser;
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
			$postData['phone'] = '00000';
			$this->createUser->setUserPost( $postData );
			$this->createUser->setCodePost( 'UBER' );
			$this->createUser->setAffiliationPost( [ 'currency_6' => 'MXN', 'amount_6' => 0, 'affiliation' => 6 ] );
			$this->createUser->setVacationFundPost( [ 'fondo' => 1, 'amount' => 0, 'currency' => 'MXN' ]  );
			if ( $this->createUser->saveData() == TRUE )
			{
				//Iniciar sesion.
				//Aqui hacer gurdar el VIIM

				if($this->guard->attempt(['email' => $postData['email'], 'password' => $postData['password']])){
					$user = Auth::user();
					$user->tierId = 80;
					
					$this->leisureLoyalty->setUser($user);
					$memberId = $this->leisureLoyalty->createOrRetriveMemberId();
					print_r($memberId);
					exit;
/*
					$user = new \stdClass();
					foreach ($postData as $key => $value)
					{
					    $user->$key = $value;
					}
*/
					$sent = Mail::send('emails.uber.welcome', array('user' => $user, 'url' => url('/')), function($message) use ($user) {	
								$full_name = $user->name . ' ' . $user->last_name;		
						    	$message->to( $user->email, $full_name )
						    			->to( 'hp_tanya@hotmail.com' , $full_name)
						    			->subject( "Bienvenido a InspiraMexico, {$full_name}!"  );
						    	});
						    	
					return Response::json(array(
						'error' => false,
						'redirect' => url('comprar-certificado')
					), 200);
				}
			}
			return view('uber.register_form')->withErrors(['Lo sentimos hubo en error al crear usuario, intente de nuevo.'])->with('title', 'Reg&iacute;strate')->with('background' , 'register.jpg');
		}
		return view('uber.register_form')->withErrors($validator)->with('title', 'Reg&iacute;strate')->with('background' , 'register.jpg');
	}
}