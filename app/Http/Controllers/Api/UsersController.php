<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Request;
use Redirect;
use Response;
use Session;
use Auth;
use Lang;
use Input;
use App\Model\Dao\UserDao;
use Illuminate\Contracts\Auth\Guard;
use App\Model\Entity\UserRegisteredPhone;

use App\Libraries\ExchangeRate\ExchangeMXNUSD;
use App\Libraries\ExchangeRate\ConvertCurrencyHelper;
use App\Libraries\CreateUser\UpdateUserAffiliation;

use App\Model\Entity\UserVacFundLog;
use App\Model\Entity\UserVacationalFunds;


class UsersController extends Controller 
{
	private $userDao;
	protected $auth;
	private $convertHelper;
	private $exchange;
	
	public function __construct(Guard $auth , UserDao $userDao, ExchangeMXNUSD $exchange )
	{
		$this->middleware('auth', ['except' => 'exists']);		
		$this->userDao = $userDao;
		$this->auth = $auth;
		$this->exchange = $exchange;
	}
	
	public function details()
	{
		return Response::json(array(
			'error' => false,
			'data' => $this->auth->user()
		), 200);
	}
	
	public function changeLanguage()
	{
		$this->userDao->load( $this->auth->user()->id );
		$this->userDao->language = $this->auth->user()->language == 'es' ? 'en' : 'es';
		$this->userDao->save();
		
		return Response::json(array(
			'error' => false,
			'redirect' => url('useraccount')
		), 200);
		
	}
	
	public function changeCurrency(){
		$user = $this->auth->user();
		

		$this->userDao->load( $user->id );
		$this->userDao->currency = $user->currency != 'USD' ? 'USD' : 'MXN';
		$this->userDao->save();
		
		
		//Hacer aqui todo el cambio del vacation fund / Revisar si se hace algo extra.
		$vacationalFundLog = new UserVacFundLog();
		$vacFundLog = $vacationalFundLog->getCurrentUserVacFundLogByUserId( $user->id );
		$userVacationalFund = new UserVacationalFunds();
		$vacFund = $userVacationalFund->getLatestByUserId( $user->id );
		
		$this->convertHelper = new ConvertCurrencyHelper();
		$this->convertHelper->setCurrencyShow( $this->userDao->currency );
		$this->convertHelper->setRateUSDMXN( $this->exchange->getTodayRate() );
		
		if( $vacFundLog ){
			$this->convertHelper->setCost( $vacFundLog->amount );
			$this->convertHelper->setCurrencyOfCost( $user->currency );
										
			$vacFundLog->amount = $this->convertHelper->getConvertAmount();
			$vacFundLog->currency = $this->userDao->currency;
			$vacFundLog->save();
		}
		
		//Esto es del balance
		if( $vacFund ) {
			$this->convertHelper->setCost( $vacFund->balance );
			$vacFund->currency = $this->userDao->currency;
			$vacFund->balance = $this->convertHelper->getConvertAmount();
			$vacFund->save();
		}

		//guardar en afiliacion

		return Response::json(array(
			'error' => false,
			'redirect' => url('useraccount')
		), 200);
	}
	
	public function exists()
	{
		$email = Input::get('email');
		
		$exists = empty($this->userDao->getByEmail( $email )) ? false : true ;	
		$message = '';
		if($exists){
			if( Lang::getLocale() == 'es' ){
				$message ='Ya existe cuenta con esta dirección de correo electrónico.';				
			}else{
				$message ='The email has already been taken.';	
			}
		}
		return Response::json(array(
			'error' => false,
			'data' => array( 'exists' => $exists, 'message' => $message )
		), 200);
	}
}