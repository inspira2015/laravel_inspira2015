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
use Session;
use Response;

use App\Model\User;
use App\Model\Dao\UserDao;
use App\Model\Dao\CountryDao;
use App\Model\Dao\StatesDao;
use App\Model\Dao\AffiliationsDao;
use App\Model\Dao\UserRegisteredPhoneDao;

use App\Model\Entity\UserAffiliation;
use App\Model\Entity\UserVacFundLog;
use App\Model\Entity\UsersPointsEntity;

use App\Services\UserPassword;
use App\Services\UserDetails;
use App\Services\Payment as PaymentValidator;

use App\Libraries\AccountValidation\CompleteAccountSetup;
use App\Libraries\GeneratePaymentsDates;
use App\Libraries\CashPayment;
use App\Libraries\SystemTransactions\CreateCashReceipt;


class UseraccountController extends Controller {
	
	private $userDao;
	private $countryDao;
	private $accountSetup;
	private $statesDao;
	private $phonesDao;
	private $userAuth;
	private $sysTransaction;
	private $userPointsDao;

	
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
								 CountryDao $countryDao,
								 StatesDao $statesDao,
								 UserRegisteredPhoneDao $phoneDao,
								 CompleteAccountSetup $accountSetup,
								 CreateCashReceipt $sysCashReceipt,
								 UsersPointsEntity $userPoints)
	{
		$this->middleware('auth');
		$this->userDao = $userDao;
		$this->countryDao = $countryDao;
		$this->statesDao = $statesDao;
		$this->phoneDao = $phoneDao;
		$this->accountSetup = $accountSetup;
		$this->userAuth = Auth::user();
		$this->sysTransaction = $sysCashReceipt;
		$this->userPointsDao = $userPoints;
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
		$errors = '';
		if(Session::has('confirmation_code')){
			$errors = array ('message' => $this->activation( Session::get('confirmation_code') ) );
			Session::forget('confirmation_code');
		}
		
		return view('useraccount.userdata')
			->with( 'title' ,  Lang::get('userdata.title') )
			->with( 'background' , '1.png')
			->with( 'user' , $this->details() )
			->with( 'accountSetup' , $this->accountSetup )
			->withErrors( $errors )
			->with( $this->getData() );
	}
	
	private function getData(){
		$paymentDate = new GeneratePaymentsDates();
		$vacationalFundLog = new UserVacFundLog();
		$userAff = new UserAffiliation();
		$affiliationsDao = new AffiliationsDao();
		
		$this->accountSetup->setUsersID( $this->userAuth->id );
		$this->accountSetup->checkValidAccount();
		
		$userAffiliation = $userAff->getCurrentUserAffiliationByUserId( $this->userAuth->id );
		$userVacationalFundLog = $vacationalFundLog->getCurrentUserVacFundLogByUserId( $this->userAuth->id );
		//$userVacationalFundLog = $queryUserVac[0];
		
		$affiliation = $affiliationsDao->getById( $userAffiliation->affiliations_id );
		$paymentDate->setDate( \date('Y-m-d') );
		$userPoints = $this->userPointsDao->getLatestByUserId( $this->userAuth->id );
		$pointBalance = 0;

		if(!empty( $userPoints ))
		{
			$pointBalance = (int)$userPoints->balance;

		}

		$data = array(
			'affiliation_cost' => $userAffiliation->amount,
			'affiliation_currency' => $userAffiliation->currency,
			'vacational_fund_amount' => $userVacationalFundLog->amount,
			'vacational_fund_currency' => $userVacationalFundLog->currency,
			'vacational_fund' => $userVacationalFundLog,
			'inspiraPointsBalance' => $pointBalance,
			'affiliation' => $affiliation,
			'userAffiliation' => $userAffiliation,
			'next_payment_date' => $paymentDate->getNextPaymentDateHumanRead()
		);

		return $data;
	}

	/**
	* Show the application dashboard to the user.
	*
	* @return Response
	*/
	public function accountSetup()
	{
		$this->accountSetup->setUsersID( $this->userAuth->id );
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
		$validator = $userDetails->validator($data, $this->userAuth->language);
		if( $validator->passes() ){
			$this->phoneDao->exchangeArray(  array ( 'users_id' => $this->userAuth->id , 'type' => 'cell', 'number' => $data['cell'] ) );
			$this->phoneDao->save();
			$this->phoneDao->exchangeArray(  array ( 'users_id' => $this->userAuth->id , 'type' => 'phone', 'number' => $data['phone'] ) );
			$this->phoneDao->save();
			$this->phoneDao->exchangeArray(  array ( 'users_id' => $this->userAuth->id , 'type' => 'office', 'number' => $data['office'] ) );
			$this->phoneDao->save();
		
			$this->userDao->load( $this->userAuth->id );
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
		return view('useraccount.form-payment')->with('user', $this->userAuth );
	}
	
	public function updatePayment()
	{
		$data = Input::except('_token');
		$amountValidator = new PaymentValidator();

		if($this->userAuth->currency == "MXN"){
			$validator = $amountValidator->validatorMXN($data, Lang::locale() );
		}else{
			$validator = $amountValidator->validatorUSD($data, Lang::locale() );
		}

		if($validator->fails()){
			return view('useraccount.form-payment')->withErrors($validator)->with('user', $this->userAuth );
		}
		
		$location = GeoIP::getLocation();
		$cashPayment = new CashPayment();
		$cashPayment->setUserData([
							'full_name' => $this->userAuth->name. ' '.$this->userAuth->last_name,
							'id' => $this->userAuth->id,
							'email' => $this->userAuth->email,
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
	
		if( $cashPayment->checkPaymentData() )
		{
			if( $cashPayment->doToken() ){
				$response = $cashPayment->getToken();

				$responseArray = (array) $response;

				if( @$cashPayment->getTransactionResponse()->extraParameters )
				{
					
					$this->sysTransaction->setUser( $this->userAuth );
					$this->sysTransaction->setTransactionInfo( array('users_id' => $this->userAuth->id,
															'code' => 'Pending',
															'type' => 'Register Cash Transaction',
															'description' => 'Cash Receipt Generated',
															'json_data' => json_encode($responseArray),
															'amount' => $data['amount'],
															'currency' => $data['currency'],
															'payu_transaction_id' => $cashPayment->getTransactionId() ) );
					$this->sysTransaction->saveData();		
				
					return view( 'useraccount.payment' )
						->with( 'user', $this->userAuth )
						->with( 'receipt', $response->transactionResponse->extraParameters->URL_PAYMENT_RECEIPT_HTML );
				}
			}
				
			$this->sysTransaction->setUser( $this->userAuth );
			$this->sysTransaction->setTransactionInfo( array('users_id' => $this->userAuth->id,
															'code' => 'ERROR',
															'type' => 'Register Cash Transaction',
															'description' => 'Couldn\'t make transaction',
															'json_data' => '' ) );
			$this->sysTransaction->saveData();		
			return view( 'useraccount.payment' )
				->withErrors( [ 'message' => Lang::get('userdata.error.transaction') ] )
				->with( 'user', $this->userAuth );
		}
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
			$this->userDao->load( $this->userAuth->id );
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
		$user = $this->userDao->getDetails( $this->userAuth->id );
		$user->details->country_code = $user->details->country;
		$user->details->country = $this->countryDao->getNameByCode($user->details->country);
		return $user;
	}
	
		/**
	 * Activates the user account with the email Url
	 *
	 * @return Response
	 */
	public function activation($code = FALSE)
	{		
		$user = $this->userDao->getUserByEmailCode( $code );

		if( empty( $user->all() ) )
		{
			return "This account has already been confirmed";
		}else{
			$this->userDao->load( $user->first()->id );
			$this->userDao->confirmed =1;
			$this->userDao->confirmation_code ='';
			$this->userDao->save();
			return "Congratulations your account has been confirmed.";
		}
	}
	
	
	
}

