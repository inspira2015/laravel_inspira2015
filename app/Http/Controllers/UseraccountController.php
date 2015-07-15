<?php 
namespace App\Http\Controllers;
use Auth;
use Input;
use App\Model\Dao\UserDao;
use App\Model\Dao\UserRegisteredPhoneDao;
use App\Services\UserPassword;
use App\Model\Entity\UserAffiliation;
use App\Libraries\AccountValidation\CompleteAccountSetup;
use App\Model\Entity\UserVacationalFunds;
use App\Model\Entity\UserVacFundLog;


class UseraccountController extends Controller {
	
	private $userDao;
	private $phoneDao;
	private $userAffDao;
	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/
	
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	 
	public function __construct( UserDao $userDao, 
								 UserRegisteredPhoneDao $phoneDao,
								 UserAffiliation $userAffiliation
								 )
	{
		$this->middleware('auth');
		$this->userDao = $userDao;
		$this->phoneDao = $phoneDao;
		$this->userAffDao = $userAffiliation;
	}
	
	/**
	* Show the application dashboard to the user.
	*
	* @return Response
	*/
	public function index(CompleteAccountSetup $userAff)
	{
		$user = new \stdClass();
		$phones = new \stdClass();
		$phones->cellphone = $this->userDao->getPhoneType( Auth::user()->id, 'cellphone');
		$phones->phone = $this->userDao->getPhoneType( Auth::user()->id, 'phone');
		$phones->office = $this->userDao->getPhoneType( Auth::user()->id, 'office');
		$user->details = $this->userDao->getById( Auth::user()->id );
		$user->phones = $phones;
		$user->address = $this->userDao->getAddress( Auth::user()->id );
		$objValidSetup = $userAff;
		$objValidSetup->setUsersID(Auth::user()->id );


		return view('useraccount.userdata')->with( 'user' , $user );
	}
	
	public function editAccount()
	{
		return view('useraccount.edit-contact');
	}
	
	public function updateAccount()
	{
		$user = new \stdClass();
		$phones = new \stdClass();
		$phones->cellphone = $this->userDao->getPhoneType( Auth::user()->id, 'cellphone');
		$phones->phone = $this->userDao->getPhoneType( Auth::user()->id, 'phone');
		$phones->office = $this->userDao->getPhoneType( Auth::user()->id, 'office');
		$user->details = $this->userDao->getById( Auth::user()->id );
		$user->phones = $phones;
		$user->address = $this->userDao->getAddress( Auth::user()->id );
		return view('useraccount.contact')->with( 'user' , $user );
	}
	
	public function editDetails(){
		$user = new \stdClass();
		$user->details = $this->userDao->getById( Auth::user()->id );
		return  view('useraccount.password')->with( array( 'action' => 'update', 'user' => $user ) );
	}
	
	public function updateDetails(){
		$user = new \stdClass();
		$user->details = $this->userDao->getById( Auth::user()->id );
		
		$data = Input::except('_token');
		
		$validator = UserPassword::validator( $data );
		if( $validator->passes() ){
			return view('useraccount.password')->with( array( 'action' => 'edit', 'user' => $user ));
		}
		return view('useraccount.password')->with( array( 'action' => 'update', 'user' => $user ))->withErrors($validator);
	}
	
	public function editLanguage(){
		$user = new \stdClass();
		$user->details = $this->userDao->getById( Auth::user()->id );
		return view('useraccount.choose-language')->with( array( 'action' => 'update', 'user' => $user) );
	}

}

