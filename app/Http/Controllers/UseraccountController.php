<?php 
namespace App\Http\Controllers;
use Auth;
use Input;
use Hash;
use App\Model\User;

use App\Model\Dao\UserDao;
use App\Model\Dao\CountryDao;
use App\Model\Dao\StatesDao;
use App\Model\Dao\UserRegisteredPhoneDao;
use App\Services\UserPassword;
use App\Model\Entity\UserAffiliation;
use App\Libraries\AccountValidation\CompleteAccountSetup;
use App\Model\Entity\UserVacationalFunds;
use App\Model\Entity\UserVacFundLog;

class UseraccountController extends Controller {
	
	private $userDao;
	private $countryDao;
	private $accountSetup;
	private $statesDao;
	private $phonesDao;
	
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
								 CompleteAccountSetup $accountSetup,
								 StatesDao $statesDao,
								 UserRegisteredPhoneDao $phoneDao,
								 CountryDao $countryDao
								 )
	{
		$this->middleware('auth');
		$this->userDao = $userDao;
		$this->countryDao = $countryDao;
		$this->statesDao = $statesDao;
		$this->phoneDao = $phoneDao;
		$this->accountSetup = $accountSetup;
	}
	
	/**
	* Show the application dashboard to the user.
	*
	* @return Response
	*/
	public function index()
	{
		$this->accountSetup->setUsersID(Auth::user()->id );
		$this->accountSetup->checkValidAccount();
		return view('useraccount.userdata')
			->with( 'user' , $this->details() )
			->with( 'accountSetup' , $this->accountSetup );
	}

	/**
	* Show the application dashboard to the user.
	*
	* @return Response
	*/
	public function accountSetup()
	{
		$this->accountSetup->setUsersID(Auth::user()->id );
		return $this->accountSetup->getRedirect();
	}
	
	public function editAccount()
	{
		$user = $this->details();
		return view('useraccount.form-contact')
			->with('user', $user )
			->with( 'countries' , $this->countryDao->forSelect('name', 'code'))
			->with( 'states', $this->statesDao->forSelect('name', 'code', array('country' => $user->details->country_code ) ));
	}
	
	public function updateAccount()
	{
		$data = Input::except('_token');
		
		//validate phones
		//$this->phoneDao->setUserId( Auth::user()->id );
		//$this->phoneDao->load();
		
		//User::phones()
		//Validate state-contry
		$this->userDao->load(Auth::user()->id);
		$this->userDao->country = $data['country'];
		$this->userDao->state = $data['state'];
		$this->userDao->save();		
		return view( 'useraccount.contact')
			->with( 'user' , $this->details() );
	}
	
	public function editPassword()
	{
		return  view('useraccount.form-password')
			->with( 'user' , $this->details() );
	}
	
	public function updatePassword()
	{
		$data = Input::except('_token');
		$validator = UserPassword::validator( $data );
		if( $validator->passes() ){
			$this->userDao->load( Auth::user()->id );
			$this->userDao->password = Hash::make($data['password']);
			$this->userDao->save();
			return view('useraccount.password')
				->with( 'user', $this->details() );
		}
		return view('useraccount.form-password')
			->with( 'user',  $this->details() )
			->withErrors($validator);
	}
		
	private function details(){
		$user = $this->userDao->getDetails( Auth::user()->id );
		$user->details->country_code = $user->details->country;
		$user->details->country = $this->countryDao->getNameByCode($user->details->country);
		return $user;
	}

}

