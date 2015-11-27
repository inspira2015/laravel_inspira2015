<?php 
namespace App\Http\Controllers\Landings\Promotions;
use App\Http\Controllers\Controller;
use App\Libraries\CreateUser\CheckAndSaveUserInfo;
use App\Services\Uber\Register as RegisterValidator;
use App\Libraries\LeisureLoyaltyUser;
use Illuminate\Contracts\Auth\Guard;
use App\Libraries\SystemTransactions\CreateUser;
use App\Model\Dao\UserDao;
use App\Model\Entity\SystemTransactionEntity;
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
	private $sysTransaction;
	
	public function __construct(Auth $auth, 
								CheckAndSaveUserInfo $checkUser, 
								Guard $guard, 
								CreateUser $createLeisureUser, 
								LeisureLoyaltyUser $leisureLoyaltyUser,
								SystemTransactionEntity $systemTransaction ){
		$this->auth = $auth;
		$this->guard  = $guard;
		$this->createUser = $checkUser;
		$this->createLeisureUser = $createLeisureUser;
		$this->leisureLoyalty = $leisureLoyaltyUser;
		$this->sysTransaction = $systemTransaction;
	}
	
	public function getRegister(){
		if(Auth::check()){
			return redirect('/');
		}
		return view('landings.__common.register')->with('title', 'Reg&iacute;strate')->with('background' , 'register.jpg');
	}
	
	public function postRegister(){
		
		$register = new RegisterValidator();
		$postData = Request::except('_token');
		$validator = $register->validator( $postData, Lang::locale() );
		
		if($validator->passes()){
			Session::put('user',  $postData );
			$postData['phone'] = '00000';
			$this->createUser->setUserPost( $postData );
			$this->createUser->setCodePost( Session::get('ref', 'inspira') );
			$this->createUser->setAffiliationPost( [ 'currency_6' => 'MXN', 'amount_6' => 0, 'affiliation' => 6 ] );
			$this->createUser->setVacationFundPost( [ 'fondo' => 1, 'amount' => 0, 'currency' => 'MXN' ]  );
			if ( $this->createUser->saveData() == TRUE )
			{
				if($this->guard->attempt(['email' => $postData['email'], 'password' => $postData['password']])){
					$userAuth = Auth::user();
					$userAuth->password = $postData['password'];
					
					$this->leisureLoyalty->setUser($userAuth);
					$this->leisureLoyalty->setTierId(80);

					//Update user.	//Guardar el memberId
					$memberId = $this->leisureLoyalty->createOrRetriveMemberId();
					if($memberId !== FALSE){
						$userDao = new UserDao();
						$userDao->load($userAuth->id);
						$userDao->leisure_id = $memberId;
						$userDao->save();
	
						$this->createLeisureUser->setUser( $userAuth );
						$this->createLeisureUser->setTransactionInfo( array('users_id' => $userAuth->id,
																			'type' => 'Create Leisure MemberId',
																			'description' => 'Create Leisure MemberId',
																			'json_data' => ''));
						$this->createLeisureUser->saveData();
	
						$sent = Mail::send('emails.landings.welcome', array('user' => $userAuth, 'domain' => 'http://Promociones.InspiraMexico.mx', 'url' => url('/')), function($message) use ($userAuth) {	
									$full_name = $userAuth->name . ' ' . $userAuth->last_name;		
							    	$message->to( $userAuth->email, $full_name )
							    			->to( 'hp_tanya@hotmail.com' , $full_name)
							    			->subject( "Bienvenido a InspiraMexico, {$full_name}!"  );
							    	});
							    	
						return Response::json(array(
							'error' => false,
							'redirect' => url('comprar-certificado')
						), 200);
					}else{
						//Find another way to Change this.
						$this->guard->logout();
						return view('landings.__common.register_form')->withErrors('Por favor de elegir otra direcci&oacute;n de correo electr&oacute;nico')->with('title', 'Reg&iacute;strate')->with('background' , 'register.jpg');
					}
				}				
			}
			return view('landings.__common.register_form')->withErrors($this->createUser->getErrors())->with('title', 'Reg&iacute;strate')->with('background' , 'register.jpg');
		}
		return view('landings.__common.register_form')->withErrors($validator)->with('title', 'Reg&iacute;strate')->with('background' , 'register.jpg');
	}
}