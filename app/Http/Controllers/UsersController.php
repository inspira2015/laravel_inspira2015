<?php 
namespace App\Http\Controllers;
use Lang;
use Request;
use Redirect;
use App\Services\UserRegistration as UserRegistration;
use App\Model\Dao\UserDao;
use App\Model\Entity\UserRegisteredPhone;
use Input;
use Mail;


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


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(UserDao $userDao,UserRegisteredPhone $userphone)
	{
		$this->middleware('guest');
		$this->userDao = $userDao;
		$this->userPhone = $userphone;

	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function Index()
	{
		$locale = Lang::getLocale();
		$data['country_list'] = $this->getCountryArray($locale);
		$data['lan_list'] = $this->getLanguaje($locale);
		$data['currency_list'] = $this->getCurrency();
		$data['locale'] = $locale;
		
		return view('users.user',$data);
	}


	public function registration()
	{
		$post_data = Request::all();
		$user_check = new UserRegistration();
		$validator = $user_check->validator($post_data);

		if($validator->passes()) 
		{
			$this->userDao->exchangeArray($post_data);
			$last_id =$this->userDao->save();
			$this->userDao->load($last_id);
			$post_data['users_id'] = $last_id;
			$this->userPhone->exchangeArray($post_data);
			$last_phone_id =$this->userPhone->save();
			$full_nam = $this->userDao->name . ' ' . $this->userDao->last_name;

			$sent =Mail::send('emails.user_registration', array('user' => $this->userDao), function($message)
			{
				$full_name = $this->userDao->name . ' ' . $this->userDao->last_name;
		    	$message->to($this->userDao->email, $full_name)->subject('Welcome!');
			});

			$data = array('full_name'=> $full_nam);
			return view('users.emailconfirmation',$data);
		}
		$locale = Lang::getLocale();
		$data['country_list'] = $this->getCountryArray($locale);
		$data['lan_list'] = $this->getLanguaje($locale);
		$data['currency_list'] = $this->getCurrency();

        return view('users.user')->with($data)->withErrors($validator)
        																	 ->withInput($request->input());
	}
	

	public function activation($code = FALSE)
	{
		if($code == FALSE)
		{
			//Error page

		}
		$userDao = new UserDao();
		$user = $userDao->getUserByEmailCode($code);
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

	public function getLogin()
	{
		return view('users.login');
	}
	
	/*protected function getUserCreateArray(array $valid_data)
	{
		return array(
					 'id' => (isset($valid_data['id'])) ? trim($valid_data['id']) : 0,
					 'leisure_id' => (isset($valid_data['leisure_id'])) ? trim($valid_data['leisure_id']) : null,
					 'email' => (isset($valid_data['email'])) ? trim($valid_data['email']) : null,
					 'password' => (isset($valid_data['password'])) ? trim($valid_data['password']) : null,
					 'active' => (isset($valid_data['active'])) ? trim($valid_data['active']) : 1,
					 'remember_token' => (isset($valid_data['remember_token'])) ? trim($valid_data['remember_token']) : null,
					 'name' => (isset($valid_data['name'])) ? trim($valid_data['name']) : null,
					 'last_name' => (isset($valid_data['last_name'])) ? trim($valid_data['last_name']) : null,
					 'confirmed' => (isset($valid_data['confirmed'])) ? trim($valid_data['confirmed']) : 0,
					 'language' => (isset($valid_data['language'])) ? trim($valid_data['language']) : 'es',
					 'created_at' => (isset($valid_data['created_at'])) ? trim($valid_data['created_at']) : date('Y-m-d H:i:s'),
					 'updated_at' => (isset($valid_data['created_at'])) ? trim($valid_data['created_at']) : date('Y-m-d H:i:s'),


					 'confirmation_code' => (isset($valid_data['confirmation_code'])) ? trim($valid_data['confirmation_code']) : null,
			);   
	}*/

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
