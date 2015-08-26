<?php 
namespace App\Http\Controllers;
use App;
use Auth;
use Input;
use Javascript;
use Config;
use Hash;
use Lang;
use GeoIP;
use Response;
use App\Model\User;

use App\Model\Dao\UserDao;
use App\Model\Dao\CountryDao;
use App\Model\Dao\StatesDao;
use App\Model\Dao\AffiliationsDao;
use App\Model\Dao\UserRegisteredPhoneDao;
use App\Services\UserPassword;
use App\Services\UserDetails;
use App\Services\Payment as PaymentValidator;

use App\Model\Entity\UserAffiliation;

use App\Libraries\AccountValidation\CompleteAccountSetup;
use App\Libraries\GeneratePaymentsDates;

use App\Model\Entity\UserVacationalFunds;
use App\Model\Entity\UserVacFundLog;


use App\Libraries\CashPayment;


class UseraccountController extends Controller {
	
	private $userDao;
	private $countryDao;
	private $accountSetup;
	private $statesDao;
	private $phonesDao;
	private $userAffiliationDao;
	private $userAuth;
	private $userVacationalFundLog;
	private $affiliationsDao;
	private $cashPayment;
	
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
								 UserAffiliation $userAff,
								 UserVacFundLog $userVacFundLog,
								 UserRegisteredPhoneDao $phoneDao,
								 AffiliationsDao $affiliationsDao,
								 CashPayment $cashPayment,
								 CountryDao $countryDao
								 )
	{
		$this->middleware('auth');
		$this->userDao = $userDao;
		$this->countryDao = $countryDao;
		$this->userAffiliationDao = $userAff;
		$this->generatePaymentesDate = new GeneratePaymentsDates();
		$this->statesDao = $statesDao;
		$this->phoneDao = $phoneDao;
		$this->accountSetup = $accountSetup;
		$this->affiliationsDao = $affiliationsDao;
		$this->userAuth = Auth::user();
		$this->userVacationalFundLog = $userVacFundLog;
		$this->chashPayment = $cashPayment;
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
		$userAuth = Auth::user();
		$userAffiliation = $this->userAffiliationDao->getCurrentUserAffiliationByUserId( $userAuth->id );

		$userVacationalFundLog = $this->userVacationalFundLog->getCurrentUserVacFundLogByUserId( $userAuth->id );
		//$userVacationalFundLog = $queryUserVac[0];
		
		$affiliation = $this->affiliationsDao->getById($userAffiliation->affiliations_id);
		$this->generatePaymentesDate->setDate( \date('Y-m-d') );
		
		$data = array(
			'affiliation_cost' => $userAffiliation->amount,
			'affiliation_currency' => $userAffiliation->currency,
			'vacational_fund_amount' => $userVacationalFundLog->amount,
			'vacational_fund_currency' => $userVacationalFundLog->currency,
			'vacational_fund' => $userVacationalFundLog,

			'affiliation' => $affiliation,
			'userAffiliation' => $userAffiliation,
			'next_payment_date' => $this->generatePaymentesDate->getNextPaymentDateHumanRead()
		);
				
		return view('useraccount.userdata')
			->with( 'title' ,  'Profile' )
			->with( 'background' , '1.png')
			->with( 'user' , $this->details() )
			->with( 'accountSetup' , $this->accountSetup )
			->with( $data );
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
		$userDetails = new UserDetails();
		$validator = $userDetails->validator($data, Auth::user()->language);
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
	
	public function editPayment(){
		return view('useraccount.form-payment')->with('user', Auth::user() );
	}
	
	public function updatePayment(){
		$data = Input::except('_token');
		$amountValidator = new PaymentValidator();
		//return Auth::user()->currency.' '.Lang::locale();
		if(Auth::user()->currency == "MXN"){
			$validator = $amountValidator->validatorMXN($data, Lang::locale() );
		}else{
			$validator = $amountValidator->validatorUSD($data, Lang::locale() );
		}

		if($validator->fails()){
			return view('useraccount.form-payment')->withErrors($validator)->with('user', Auth::user() );
		}
		
		$location = GeoIP::getLocation();
		$cashPayment = new CashPayment();
		$cashPayment->setUserData([
							'full_name' => Auth::user()->name. ' '.Auth::user()->last_name,
							'id' => Auth::user()->id,
							'email' => Auth::user()->email,
							'location' => $location['ip']
						]);
		
		
		$cashPayment->setAmountData([
							'value' => $data['amount'],
							'currency' => $data['currency']
						]);
		$cashPayment->setItem([
				'reference' => 'Item-test-'.time(),
				'description' => 'Test dresciption'
			]);
	
		if( $cashPayment->checkPaymentData() ){
			//dependiendo de lo que tenga el response
			$response = $cashPayment->capture();
			if($response->code == 'SUCCESS'){

				return view('useraccount.payment')
						->with('user', Auth::user() )
						->with('receipt', $response->transactionResponse->extraParameters->URL_PAYMENT_RECEIPT_HTML);
			}
			else{
				return view('useraccount.payment')->withErrors(array('message' => 'There was an error while processing' ))->with('user', Auth::user() );
			}
			
		}
		return "buuu error (n)";
	}
	
	
	public function editPassword()
	{
		return  view('useraccount.form-password')
			->with( 'user' , $this->details() );
	}
	
	public function updatePassword()
	{
		$userPassword = new UserPassword();
		$data = Input::except('_token');
		$validator = $userPassword->validator( $data, Lang::locale() );
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

