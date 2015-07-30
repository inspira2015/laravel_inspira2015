<?php 
namespace App\Http\Controllers;
use Lang;
use Request;
use Redirect;
use App\Services\UserRegistration as UserRegistration;
use App\Model\Dao\UserDao;
use App\Model\Dao\UserRegisteredPhoneDao as UserRegisteredPhone;
use App\Model\Entity\CodesUsedEntity;
use App\Model\Dao\CodeDao;
use App\Libraries\CodeValidator as CodeValidator;
use App\Libraries\Referer\CheckReferer;
use Input;
use Mail;
use Session;
use URL;


class UsersController extends Controller {

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


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(UserDao $userDao, 
								UserRegisteredPhone $userphone, 
								CodesUsedEntity $codesUsed,
								CodeDao $codeDao )
	{
		$this->middleware('guest');
		$this->userDao = $userDao;
		$this->userPhone = $userphone;
		$this->codesUsed = $codesUsed;
		$this->codeDao = $codeDao;
		$this->check = new CodeValidator();
		$this->checkReferer = new CheckReferer();
	}

	/**
	 * Show the User Registration Form
	 *
	 * @return Response
	 */
	public function Index()
	{
		if ( $this->checkSession() == FALSE )
		{
			return Redirect::to('codes/1');
		}
		$locale = Lang::getLocale();
		$data['country_list'] = $this->getCountryArray($locale);
		$data['lan_list'] = $this->getLanguaje($locale);
		$data['currency_list'] = $this->getCurrency();
		$data['locale'] = $locale;
		
		if ( Session::has('users') )
		{			
			return view('users.user')->with($data)->with( Session::get('users') );
		}
		return view('users.user',$data);
	}


	public function checkSession()
	{
		$this->checkReferer->setRefererUrl( URL::previous() );
		$this->checkReferer->setValidUrl( 'codes' );
		$this->checkReferer->setValidUrl( 'affiliation' );
		return $this->checkReferer->checkValid();
	}

	/**
	 * Validates user Form data, creates a new user, send email to the new user to validate their data.
	 *
	 * @return Response
	 */
	public function registration()
	{
		$post_data = Request::all();
		$user_check = new UserRegistration();
		$validator = $user_check->validator($post_data);

		if($validator->passes()) 
		{
			Session::put('users',  $post_data );
			return Redirect::to('affiliation');
		}

		$locale = Lang::getLocale();
		$data['country_list'] = $this->getCountryArray($locale);
		$data['lan_list'] = $this->getLanguaje($locale);
		$data['currency_list'] = $this->getCurrency();
        return view('users.user')->with($data)->withErrors($validator)
        																	 ->withInput($post_data);
	}
	
	/**
	 * Activates the user account with the email Url
	 *
	 * @return Response
	 */
	public function activation($code = FALSE)
	{
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
			return view('users.erroractivation');
		}

		$this->userDao->load($user->first()->id);
		$this->userDao->confirmed =1;
		$this->userDao->confirmation_code ='';
		$this->userDao->save();
		$full_name = $this->userDao->name . ' ' . $this->userDao->last_name;
		$data = array('full_name'=> $full_name);
		return view('users.accountactivation',$data);
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


	protected function getCountryArray($language = FALSE)
	{
		if($language== 'es' || $language==FALSE)
		{
			$country_list = array( 0 => 'Seleccione un pais',
								   'MX' => 'Mexico',
								   'US' => 'Estados Unidos de America');
		}
		else
		{
			$country_list = array( 0 => 'Chose a Country',
								   'MX' => 'Mexico',
								   'US' => 'USA');
		}
		return $country_list;
	}

	protected function getLanguaje($language = FALSE)
	{
		if($language== 'es' || $language==FALSE)
		{
			$lan = array(
								   'es' => 'Español',
								   'en' => 'Ingles');
		}
		else
		{
			$lan = array(
								   'es' => 'Spanish',
								   'en' => 'English');
		}
		return $lan;
	}

	protected function getCurrency()
	{
		return array('MXN' => 'PESOS','USD' => 'DOLLAR');
	}

}
