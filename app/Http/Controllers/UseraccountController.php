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
use Redirect;
use Request;
// use Socialize;

use App\Model\User;
use App\Model\Dao\UserDao;
use App\Model\Dao\CodeDao;
use App\Model\Dao\CountryDao;
use App\Model\Dao\StatesDao;
use App\Model\Dao\AffiliationsDao;
use App\Model\Dao\UserAffiliationDao;
use App\Model\Dao\UserRegisteredPhoneDao;

use App\Model\Entity\UserAffiliation;
use App\Model\Entity\UserVacFundLog;
use App\Model\Entity\UserVacationalFunds;
use App\Model\Entity\UsersPointsEntity;
use App\Model\Dao\SystemTransactionDao;

use App\Services\UserPassword;
use App\Services\UserDetails;
use App\Services\Payment as PaymentValidator;
use App\Services\PaymentCC as PaymentMethodCC;
use App\Libraries\ConnectUserWithFacebook;
use App\Libraries\ConvertMoneyAmountToPoints;
use App\Libraries\AccountValidation\CompleteAccountSetup;
use App\Libraries\GeneratePaymentsDates;
use App\Libraries\CardPayment;
use App\Libraries\CashPayment;

use App\Libraries\SystemTransactions\CreateCashReceipt;

use App\Libraries\ExchangeRate\ExchangeMXNUSD;
use App\Libraries\ExchangeRate\ConvertCurrencyHelper;
use App\Libraries\AddInspiraPoints;
use App\Libraries\GetLastBalance;

use App\Model\Entity\UserAffiliationPaymentEntity;
use App\Libraries\Interfaces\AuthenticateUserListener;
use App\Libraries\SystemTransactions\CreateLeisureUser;
use App\Libraries\LeisureLoyaltyUser;


class UseraccountController extends Controller{
	
	private $userDao;
	private $countryDao;
	private $accountSetup;
	private $statesDao;
	private $phonesDao;
	private $userAuth;
	private $sysTransaction;
	private $userPointsDao;
	private $convertHelper;
	private $exchange;
	private $userAffiliationPayment;
	private $lastUserBalance;
	private $createLeisureUser;
	private $leisureLoyaltyUser;
	
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
								 UsersPointsEntity $userPoints,
								 UserAffiliationPaymentEntity $userAffPayment,
								 ExchangeMXNUSD $exchange,
								 GetLastBalance $lastBalance,
								 CreateLeisureUser $createLeisureUser,
								 LeisureLoyaltyUser $leisureLoyaltyUser
								 )
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
		$this->exchange = $exchange;
		$this->convertHelper = new ConvertCurrencyHelper();
		$this->convertHelper->setCurrencyShow( $this->userAuth['currency'] );
		$this->convertHelper->setRateUSDMXN( $this->exchange->getTodayRate() );
		$this->userAffiliationPayment = $userAffPayment;
		$this->createLeisureUser = $createLeisureUser;
		$this->setLanguage();
		$this->convertMoneyToPoints = new ConvertMoneyAmountToPoints();
		$this->lastUserBalance = $lastBalance;
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

		$data = $this->getData();
		
		if($this->userAuth->confirmation_code){
			return Redirect::to('users/activation/'.$this->userAuth->confirmation_code);
		}
		
		if($this->userAuth->days_overdue == 5){
			return Redirect::to('payment/credit-card');
		}
		
		
		$userObj = $this->userAuth->toArray();
		
		
		if(empty($this->userAuth->city)){
			Session::put('complete-profile', 'false');
		}
		$this->createLeisureUser->setUser( $this->userAuth );
		if(!$this->userAuth->leisure_id ) {
			$this->createLeisureUser->setTransactionInfo( array('users_id' => $this->userAuth->id,
																	'type' => 'Create Leisure MemberId',
																	'description' => 'Create Leisure MemberId',
																	'json_data' => ''));
			$this->createLeisureUser->saveData();
			return redirect('useraccount');
		}
		
		$this->accountSetup->setUsersID( $this->userAuth->id );
		$valid = $this->accountSetup->checkValidAccount();
		
		if(! $this->accountSetup->checkValidAccount() && $data['userAffiliation']['amount'] > 0 ){
			return Redirect::to('payment');
		}

		return view('useraccount.userdata')
			->with( 'title' ,  Lang::get('userdata.title') )
			->with( 'background' , '1.png')
			->with( 'user' , $this->details() )
			->with( 'location', GeoIP::getLocation() )
			->withErrors( $errors )
			->with( $data );
	}
	
	private function getData(){
		$paymentDate = new GeneratePaymentsDates();
		$vacationalFundLog = new UserVacFundLog();
		$userAff = new UserAffiliation();
		$affiliationsDao = new AffiliationsDao();
		$vacationalFund = new UserVacationalFunds();
		$vacFundTotal = $vacationalFund->getLatestByUserId($this->userAuth->id);
		$vacFundTotal = isset($vacFundTotal->balance) ? $vacFundTotal->balance : 0;
		$code = $this->userDao->getUsersCode( $this->userAuth->id );
		$codeDao = new CodeDao();
		$code = $codeDao->getById($code->code_used->codes_id);

		$this->accountSetup->setUsersID( $this->userAuth->id );
		$this->accountSetup->checkValidAccount();
		
		$userAffiliation = $userAff->getCurrentUserAffiliationByUserId( $this->userAuth->id );
		$userAffiliation->currency_change_to = $userAffiliation->currency == 'MXN' ? 'USD' : 'MXN';
		
		$this->convertHelper->setCost($userAffiliation->amount);
		$this->convertHelper->setCurrencyOfCost($userAffiliation->currency);
		
		$userVacationalFundLog = $vacationalFundLog->getCurrentUserVacFundLogByUserId( $this->userAuth->id );
		$affiliation = $affiliationsDao->getById( $userAffiliation->affiliations_id );

		$paymentDate->setDate( $userAffiliation->created_at->format('Y-m-d') );
		$paymentAffiliationDate = $paymentDate->getNextPaymentDateHumanRead();
		$paymentDate->setDate( $userVacationalFundLog->created_at->format('Y-m-d') );
		$paymentVacationDate = $paymentDate->getNextPaymentDateHumanRead();
		$userPoints = $this->userPointsDao->getLatestByUserId( $this->userAuth->id );
		$pointBalance = 0;

		if(!empty( $userPoints ))
		{
			$pointBalance = (int)$userPoints->balance;
		}
		
		$data = array(
			'affiliation_cost' => $this->convertHelper->getFomattedAmount(),
			'affiliation_currency' => $this->convertHelper->getCurrencyShow(),
			'vacational_fund_total' => $vacFundTotal,
			'vacational_fund_amount' => $userVacationalFundLog->amount,
			'vacational_fund_currency' => $userVacationalFundLog->currency,
			'currency_change_to' => $userVacationalFundLog->currency != 'MXN' ? 'MXN' : 'USD',
			'vacational_fund' => $userVacationalFundLog,
			'inspiraPointsBalance' => $pointBalance,
			'affiliation' => $affiliation,
			'userAffiliation' => $userAffiliation,
			'accountSetup' => $this->accountSetup, 
			'next_payment_date' => $paymentAffiliationDate,
			'next_payment_vacation_date' => $paymentVacationDate,
			'convertHelper' => $this->convertHelper,
			'code' => $code
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
			$this->phoneDao->exchangeArray(  array ( 'users_id' => $this->userAuth->id , 'type' => 'cellphone', 'number' => $data['cellphone'] ) );
			$this->phoneDao->save();
			$this->phoneDao->exchangeArray(  array ( 'users_id' => $this->userAuth->id , 'type' => 'phone', 'number' => $data['phone'] ) );
			$this->phoneDao->save();
			$this->phoneDao->exchangeArray(  array ( 'users_id' => $this->userAuth->id , 'type' => 'office', 'number' => $data['office'] ) );
			$this->phoneDao->save();
		
			$this->userDao->load( $this->userAuth->id );
			$this->userDao->address = $data['address'];
			$this->userDao->city = $data['city'];		
			$this->userDao->state = $data['state'];
			$this->userDao->save();		
			
			if( Session::has('complete-profile')){
				Session::forget('complete-profile');
			}
		
			return view( 'useraccount.contact')
				->with( 'user' , $this->details() );
		}
		
		$user = $this->details();

		return $this->htmlResponseContinue( implode(' ',$validator->errors()->all()) );
	}
	
	public function editPayment(){
		//dpendiendo del seleccionado, enviarle el tipo para que se genere el recibo.
		//Marcar error si no selecciono ninguno
		$type = Input::get('type');
		
		return view('useraccount.form-payment')->with('user', $this->userAuth )->with('type', $type);
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
				'description' => 'Test description', 
				'method' => $data['payment_on']
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
			
		return $this->htmlResponseContinue( implode(' ',$validator->errors()->all()) );
	}
		
	private function details(){
		$user = $this->userDao->getDetails( $this->userAuth->id );
		if(!$user->details->state){
			Session::put('complete-profile', false);
		}
		$user->details->country_code = $user->details->country;
		$user->details->country = $this->countryDao->getNameByCode($user->details->country);
		$user->details->state_code = $user->details->state;
		$user->details->state = $this->statesDao->getNameByCode($user->details->state_code);
		return $user;
	}
	
	public function postFbUnlink(){
		//Post con facebook login.
		$this->userDao->load($this->userAuth->id);
		$this->userDao->facebook_id = null;
		$this->userDao->save();
		
		$validator = array();
		return view('useraccount.password')
			->with( 'user',  $this->details() );
	}	
	
	public function userHasLoggedIn($user){
		return "hola";
	}
}

