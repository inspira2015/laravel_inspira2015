<?php 
namespace App\Http\Controllers;
use Request;
use Redirect;
use Input;
use Mail;
use Session;
use URL;
use Crypt;
use Lang;
use App\Libraries\Affiliations\ParseCurrencyFromPost;
use App\Libraries\CreateUser\CheckAndSaveUserInfo;
use App\Services\UserRegistration;
use App\Services\VacationFund;
use App\Model\Entity\UserVacFundLog;
use Auth;
use App\Libraries\CreateUser\UpdateVacationalFund;


class VacationfundsController extends Controller 
{

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
	private $parseAff;
	private $createUser;
	private $userDao;
	private $userVacationalFundLog;
	private $updateVacationalFund;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct( CheckAndSaveUserInfo $checkUser,
								 UserVacFundLog $userVac,
								 UpdateVacationalFund $updateVacational )
	{
        $this->middleware('auth', ['only' => ['changevacationalfund', 'postdochange']]);
		$this->parseAff = new ParseCurrencyFromPost();
		$this->createUser = $checkUser;
		$this->userVacationalFundLog = $userVac;
		$this->updateVacationalFund = $updateVacational;
		$this->setLanguage();
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function Index()
	{
		if ( $this->checkSession() == FALSE )
		{
			return Redirect::to('codes/1');
		}

		$this->parseAff->setAffiliationPost( Session::get( 'affiliation' ) );
		$userData = Session::get('users');


		return view('vacationfunds.vacationfund')->with(array('title' => Lang::get('vacationfund.title') ,
															  'background' =>'4.jpg',
															   'userCurrency' => $userData['currency'],
															   'name' => $userData['name'],
															   ));
	}



	public function create()
	{
		if ( $this->checkSession() == FALSE )
		{
			return Redirect::to('codes');
		}
		$post_data = Request::all();
		Session::put('vacationfund',  $post_data );
		$user = Session::get( 'users' );

		$userValidator = new UserRegistration();		
		$userValidation = $userValidator->validator( $user , Lang::getLocale() );

		$fundValidator = new VacationFund();
		$fundValidation = $fundValidator->validator(Session::get( 'vacationfund' ), Lang::getLocale());
		
		if( ! $userValidation->passes() ){
			return Redirect::to('vacationfund')->withErrors($userValidation);
		}
		if(! $fundValidation->passes() ){
			return Redirect::to('vacationfund')->withErrors($fundValidation);
		}




		$affiliation = Session::get( 'affiliation' );	
		$this->createUser->setUserPost( $user );
		$this->createUser->setCodePost( Session::get( 'code' ) );
		$this->createUser->setAffiliationPost( Session::get( 'affiliation' ) );
		$this->createUser->setVacationFundPost( Session::get( 'vacationfund' ) );



		if ( $this->createUser->saveData()== FALSE )
		{
			return Redirect::to('codes');

		}
		$credentials = array();
		$sessionUser = Session::get('users');
		
		$url = url( 'auth/autologin', array( 'email' => $user['email'], 'encryptedPassword' => Crypt::encrypt($user['password']) ));
	
		Session::forget('code');
		Session::forget('users');
		Session::forget('affiliation');
		Session::forget('vacationfund');

		$this->userDao = $this->createUser->getUserDao();
		$sent =Mail::send('emails.user_registration', array('user' => $this->userDao, 'url' => $url ), function($message)
			{
				$full_name = $this->userDao->name . ' ' . $this->userDao->last_name;
				
		    	$message->to( $this->userDao->email, $full_name )->to( 'hp_tanya@hotmail.com' , $full_name)->subject( Lang::get('emails.welcome-to')." InspiraMexico, {$full_name}!" );
			});

		$full_name = $this->userDao->name . ' ' . $this->userDao->last_name;
		$data = array('full_name'=> $full_name);
		return view('users.emailconfirmation',$data)->with('title', Lang::get('emails.email-confirmation') )->with('background','2.jpg');
	}

	public function changevacationalfund($vacationfund = FALSE)
	{
		$userAuth = Auth::user();
		Session::put('currentVacationalFund',  $vacationfund );
		$vacFund = $this->userVacationalFundLog->getById( $vacationfund);




		return view('vacationfunds.vacationfundchange')->with(array('title' => Lang::get('vacationfund.title') ,
															  'background' =>'4.jpg',
															  'amount' => $vacFund->amount,
															   'userCurrency' => $userAuth->currency,
															   'name' => $userAuth->name,
															   ));		
	}


	public function dochange()
	{
		$userAuth = Auth::user();
		$post_data = Request::all();

		$userCurrentVacationalFund = Session::get('currentVacationalFund');
		if( !is_numeric( $userCurrentVacationalFund ) )
		{
			return Redirect::to('/useraccount');
		}

		$this->updateVacationalFund->setUserId( $userAuth->id );
		$this->updateVacationalFund->setVacationFundPost( $post_data );
		$this->updateVacationalFund->setCurrentVacationalFund( $userCurrentVacationalFund );
		$this->updateVacationalFund->changeVacationalFund();
		Session::forget('currentVacationalFund');
		return Redirect::to('/useraccount');


	}


	private function checkSession()
	{
		$registrySession = Session::get('registrySession');
		$users = Session::get('users');
		$affiliation = Session::get('affiliation');
		if( empty($registrySession) || empty($users)  || empty($affiliation)  )
		{
			return FALSE;
		}
		return TRUE;
	}


}
