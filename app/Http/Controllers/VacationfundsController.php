<?php 
namespace App\Http\Controllers;
use Request;
use Redirect;
use Input;
use Mail;
use Session;
use URL;
use Lang;
use App\Libraries\Affiliations\ParseCurrencyFromPost;
use App\Libraries\CreateUser\CheckAndSaveUserInfo;
use App\Services\UserRegistration;
use App\Services\VacationFund;


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

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(CheckAndSaveUserInfo $checkUser)
	{
		$this->middleware('guest');
		$this->parseAff = new ParseCurrencyFromPost();
		$this->createUser = $checkUser;
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function Index()
	{
		if ( !Session::has('users') )
		{			
			return Redirect::to('codes/1');
		}
		$users = Session::get('users');

		if ( !Session::has('affiliation') )
		{			
			return Redirect::to('codes/1');
		}

		$this->parseAff->setAffiliationPost( Session::get( 'affiliation' ) );
		$userData = Session::get('users');


		return view('vacationfunds.vacationfund')->with(array('title' =>'Fondo Vacacional',
															  'background' =>'4.jpg',
															   'userCurrency' => $userData['currency'],
															   'name' => $users['name'],
															   'currency' => $this->parseAff->getCurrency(),
															   ));
	}



	public function create()
	{
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

		$this->userDao = $this->createUser->getUserDao();
		$sent =Mail::send('emails.user_registration', array('user' => $this->userDao), function($message)
			{
				$full_name = $this->userDao->name . ' ' . $this->userDao->last_name;
		    	$message->to( $this->userDao->email, $full_name )->subject( Lang::get('emails.welcome-to')." InspiraMexico, {$full_name}!" );
			});

		$full_name = $this->userDao->name . ' ' . $this->userDao->last_name;
		$data = array('full_name'=> $full_name);
		return view('users.emailconfirmation',$data)->with('title', "Confirmacion de email" )->with('background','2.jpg');
	}


}
