<?php 
namespace App\Http\Controllers;
use Javascript;
use Config;
use Lang;
use Request;
use Redirect;
use Crypt;

use App\Services\UserRegistration as UserRegistration;
use App\Model\Dao\UserDao;
use App\Model\Dao\UserRegisteredPhoneDao as UserRegisteredPhone;
use App\Model\Entity\CodesUsedEntity;
use App\Model\Dao\CodeDao;
use App\Model\Dao\CountryDao;
use App\Model\Dao\StatesDao;
use App\Libraries\CodeValidator as CodeValidator;
use App\Libraries\Referer\CheckReferer;

use App\Libraries\Interfaces\AuthenticateUserListener;
use App\Libraries\CreateUserWithFacebook;
use App\Libraries\ConnectUserWithFacebook;

use Auth;
use App\Libraries\UpdateDataBaseLeisureMember;
use App\Model\Entity\UserAffiliation;


use Input;
use Mail;
use Session;
use URL;
use Response;
use GeoIP;



class UsersController extends Controller implements AuthenticateUserListener {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	private $userDao;
	private $userPhone;
	private $codesUsed;
	private $codesDao;
	private $checkReferer;
	private $userAffiliation;


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(UserDao $userDao, 
								UserRegisteredPhone $userphone, 
								CodesUsedEntity $codesUsed,
								CodeDao $codeDao)
	{

		$this->middleware('both', ['only' => 'fbConnect']);

		$this->userDao = $userDao;
		$this->userPhone = $userphone;
		$this->codesUsed = $codesUsed;
		$this->codeDao = $codeDao;
		$this->check = new CodeValidator();
		$this->checkReferer = new CheckReferer();
		$this->setLanguage();
	}

	/**
	 * Show the User Registration Form
	 *
	 * @return Response
	 */
	public function Index(CreateUserWithFacebook $authfb)
	{
		if ( $this->checkSession() == FALSE )
		{
			return Redirect::to('codes/1');
		}

		if( $this->checkFacebook() == TRUE ){
    		return $authfb->execute(Request::get('code'), $this);
		}
		

		//Saves user fb data to session.
		
		JavaScript::put([ 'countries' => Config::get('extra.countries') ]);
		$locale = Lang::getLocale();
		$data = array(	'title' => Lang::get('registry.title') ,
						'background' =>'2.jpg',
						'country_list' => $this->getCountryArray(),
						'lan_list' => $this->getLanguaje(),
						'currency_list' => $this->getCurrency( Session::get('code', null) ),
						'locale' => $locale,
						'location_info' => $this->getLocationInfo()
			);

		if ( Session::has('users') )
		{			
			return view('users.user')
					->with('background','2.jpg')
					->with($data)
					->with( Session::get('users') );
					
		}
		return view('users.user',$data)
					->with('background','2.jpg');
	}
	
	public function confirmation(){	

		if(Session::get('full_name')){
			Session::forget('code');
			Session::forget('users');
			Session::forget('affiliation');
			Session::forget('vacationfund');
			return view('users.emailconfirmation',array( 'full_name' => Session::get('full_name')))->with('title', Lang::get('emails.email-confirmation') )->with('background','2.jpg');
		}
		
		return Redirect::to('codes');
	}

	public function checkFacebook(){
		if(Session::get('creation-ref')){
			return TRUE;			
		}
		return FALSE;
	}

	public function checkSession()
	{
		$registrySession = Session::get('registrySession');
		$code = Session::get('code');
		if(empty($code))
		{
			Session::put('code','default');
		}
		if( empty($registrySession) )
		{
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Validates user Form data, creates a new user, send email to the new user to validate their data.
	 *
	 * @return Response
	 */
	public function registration()
	{
		JavaScript::put([ 'countries' => Config::get('extra.countries') ]);

		$post_data = Request::all();
		$user_check = new UserRegistration();
		
				
		$post_data['cellphone_number'] = $this->sanitizePhone($post_data['cellphone_number']);
		$validator = $user_check->validator($post_data, Lang::getLocale());

		if($validator->passes()) 
		{
			Session::put('users',  $post_data );
			Session::put('registrySession', $this->rand_string( 8 ) );

			return Response::json(array(
				'error' => false,
				'redirect' => 'affiliation'
			), 200);
		}
		
		$locale = Lang::getLocale();
		$data['country_list'] = $this->getCountryArray();
		$data['lan_list'] = $this->getLanguaje();
		$data['currency_list'] = $this->getCurrency();
		$data['location_info'] = $this->getLocationInfo($post_data['country']);
		
		return $this->htmlResponseContinue( implode(' ',$validator->errors()->all()) );
	}

	private function sanitizePhone($phone)
    {  
        $phone = trim($phone);      
        $result = str_replace(array( '(', ')','-',' ' ), '', $phone);
        return $result;
    }


	/**
	 * Activates the user account with the email Url
	 *
	 * @return Response
	 */
	public function activation($code = FALSE)
	{
		if(!Auth::check()){
			return redirect('auth/login');
		}
		if($code == FALSE)
		{
			//Error page
			return view('users.erroractivation');
		}
		$userDao = new UserDao();
		$user = $userDao->getUserByEmailCode( $code );

		if( empty( $user->all() ) )
		{
			//Error page
			return view('users.erroractivation')->with('title', Lang::get('activation.title') )->with('background','2.jpg');
		}
		
		$userAff = new UserAffiliation();
		$updateDbLeisure = new UpdateDataBaseLeisureMember( $userDao, $userAff );
		
		$this->userDao->load($user->first()->id);
		$this->userDao->confirmed =1;
		$this->userDao->confirmation_code ='';
		
		$updateDbLeisure->setUserId( $user->first() );
		
		$updateDbLeisure->saveMemberId();
		$this->userDao->save();
		
		$full_name = $this->userDao->name . ' ' . $this->userDao->last_name;
		$data = array('full_name'=> $full_name);

		//Create leisure_id
		
		$this->userDao->password = Crypt::decrypt(Session::get('password'));
		$sent = Mail::send('emails.user_welcome', array('user' => $this->userDao ), function($message) {	
				$full_name = $this->userDao->name . ' ' . $this->userDao->last_name;		
		    	$message->to( $this->userDao->email, $full_name )->subject( Lang::get('emails.welcome-to')." InspiraMexico, {$full_name}!" );
		});
		
		return view('users.accountactivation',$data)->with('title', Lang::get('activation.title') )->with('background','2.jpg');
	}


	public function getForgotpassword()
	{
		return view('users.forgotpassword');
	}

	public function getUserdata()
	{
	    
		return view('users.userdata');
	}
	
	public function getLeisure()
	{
		return view('users.leisure');
	}


	protected function getCountryArray()
	{
		$country = new CountryDao();
		return $country->forSelect('name', 'code');
		
	}
	
	
	protected function getStatesArray( $country_code )
	{
		$states = new StatesDao();
		//default MX - check if its gonna be changed.
		
		if( in_array( $country_code, Config::get('extra.countries') ) )
		{
			return $states->forSelect('name', 'code', array('country' => $country_code ));
		}
		return $states->forSelect('name', 'code');
	}
	
	
	protected function getLocationInfo( $country_code = FALSE, $state = FALSE )
	{
		$countryDao = new CountryDao();
		if( $country_code == FALSE ) {
			$location = GeoIP::getLocation();
			$country_code = $location['isoCode'];
			$state = $location['state'];
		}
		$country = $countryDao->getCountryByCode( $country_code );
		$data['states'] = $this->getStatesArray( $country_code );
		$data['state_code'] = $state;
		$data['country_code'] = $country_code;
		if( ! Session::has('users.language') ){
			Session::put('users.language' , Session::get('lang'));
		}
		$data['language'] = Session::get('users.language' , $country['language']);
		$data['currency'] = $country['currency'];
		$this->setLanguage();
		return $data;
	}
	
	protected function getLanguaje()
	{
		return array(
			   'es' => 'Español',
			   'en' => 'English');
	}

	protected function getCurrency( $code = FALSE )
	{	
		if( in_array($code, ['intel']) )
		{
			return array('USD' => 'DOLLAR');
		}
		else{
			return array('MXN' => 'PESO','USD' => 'DOLLAR');			
		}
	}

	public function refreshLanguage(){
		$post_data = Request::all();
		Session::put('users',  $post_data );
		
		return Response::json(array(
			'error' => false,
			'redirect' => url('users')
		), 200);
	}
	
	
    public function fbConnect(ConnectUserWithFacebook $authfb, Request $request, CreateUserWithFacebook $createfb)
    {
	    if( $this->checkFacebook() == TRUE ){
		  //  Session::forget('creation-ref');
		   	return $createfb->execute(Request::get('code'), $this);
	    }else{
    		return $authfb->execute(Request::get('code'), $this);	
	    }
    }
    
    public function redirectPath() {
        return'/useraccount';
    }
    
    
    public function userHasLoggedIn($user)
    {
        Session::flash('message', "Ha iniciado sesión con éxito");
        Session::flash('alert-class', 'alert-success');

        return redirect()->intended($this->redirectPath());
    }
    
    public function tryAgain(CreateUserWithFacebook $authfb){
    	return $authfb->execute(Request::get('code'), $this);	
	    return "User doesnt exist, want to create an account?";
    }
    
    public function registry( Array $user ){
	    JavaScript::put([ 'countries' => Config::get('extra.countries') ]);
		$default_number = 123456789;
		$post_data['cellphone_number'] = $default_number;
		$post_data = Request::all();
		$user_check = new UserRegistration();
		
		$location = $this->getLocationInfo();

		$random_pass = str_random(8);
    	$post_data['name'] = $user['first_name'];
    	$post_data['password'] = $random_pass;
    	$post_data['password_confirmation'] = $random_pass;
    	$post_data['last_name'] = $user['last_name'];
    	$post_data['email'] = $user['email'];
    	$post_data['facebook_id'] = $user['id'];
    	$post_data['facebook_avatar'] = $user['avatar'];
    	$post_data['gender'] = $user['gender'];
		$post_data['cellphone_number'] = $default_number."00";
		$post_data['country'] =  $location['country_code'];
		$post_data['state'] = $location['state_code'];
		$post_data['cellphone_number'] = $this->sanitizePhone($post_data['cellphone_number']);
		$validator = $user_check->validator($post_data, Lang::getLocale());
		$post_data['currency'] = $location['currency'];
		$post_data['language'] = Session::get('lang');
		
		if($validator->passes()) 
		{
			Session::put('users',  $post_data );
			return Redirect::to('affiliation');
		}
		
		$locale = Lang::getLocale();
		$data['country_list'] = $this->getCountryArray();
		$data['lan_list'] = $this->getLanguaje();
		$data['currency_list'] = $this->getCurrency();
		$data['location_info'] = $this->getLocationInfo($post_data['country']);

        return view('users.user')
		        ->with('title', Lang::get('registry.title') )
		        ->with('background','2.jpg')
		        ->with($data)
		        ->withErrors($validator)
		        ->withInput($post_data);
    }

	private  function rand_string( $length ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

		$size = strlen( $chars );
		$str = '';
		for( $i = 0; $i < $length; $i++ ) 
		{
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}


	
}