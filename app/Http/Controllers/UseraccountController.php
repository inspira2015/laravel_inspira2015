<?php 
namespace App\Http\Controllers;
use App;
use Auth;
use Input;
use Javascript;
use Config;
use Hash;
use App\Model\User;

use App\Model\Dao\UserDao;
use App\Model\Dao\CountryDao;
use App\Model\Dao\StatesDao;
use App\Model\Dao\UserRegisteredPhoneDao;
use App\Services\UserPassword;
use App\Services\UserDetails;
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
		$this->setLanguage();
	}
	
	/**
	* Show the application dashboard to the user.
	*
	* @return Response
	*/
	public function index()
	{
		JavaScript::put([ 'countries' => Config::get('extra.countries') ]);

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

		//Validar esta parte
		$validator = UserDetails::validator($data);
		if( $validator->passes() ){
			$this->phoneDao->exchangeArray(  array ( 'users_id' => Auth::user()->id , 'type' => 'cell', 'number' => $data['cell'] ) );
			$this->phoneDao->save();
			$this->phoneDao->exchangeArray(  array ( 'users_id' => Auth::user()->id , 'type' => 'phone', 'number' => $data['phone'] ) );
			$this->phoneDao->save();
			$this->phoneDao->exchangeArray(  array ( 'users_id' => Auth::user()->id , 'type' => 'office', 'number' => $data['office'] ) );
			$this->phoneDao->save();
		
			$this->userDao->load( Auth::user()->id );
			$this->userDao->address = $data['address'];
			$this->userDao->city = $data['city'];		
			$this->userDao->country = $data['country'];
			$this->userDao->state = $data['state'];
			$this->userDao->save();		
			
			return view( 'useraccount.contact')
				->with( 'user' , $this->details() );
		}
		$user = $this->details();
		return view( 'useraccount.form-contact')
				->with( 'user' , $user )
				->with( 'countries' , $this->countryDao->forSelect('name', 'code'))
				->with( 'states', $this->statesDao->forSelect('name', 'code', array('country' => $user->details->country_code ) ))
				->withErrors($validator);

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

