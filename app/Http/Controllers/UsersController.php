<?php 
namespace App\Http\Controllers;
use Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Validator;
use App\Services\UserRegistration as UserRegistration;
use App\Model\Dao\UserDao;

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


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(UserDao $userDao)
	{
		$this->middleware('guest');
		$this->userDao = $userDao;

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
		$this->userDao->load(2);
		echo $this->userDao->email;
		return view('users.user',$data);
	}

	public function registration(Request $request,UserRegistration $userCheck)
	{
		$post_data = $request->all();
		$validator = $userCheck->validator($post_data);

		if($validator->passes()) 
		{
			$user = $this->getUserCreateArray($post_data);
			$this->userDao->exchangeArray($post_data);
			$this->userDao->save($post_data);
			exit;
		}
		$locale = Lang::getLocale();
		$data['country_list'] = $this->getCountryArray($locale);
		$data['lan_list'] = $this->getLanguaje($locale);
		$data['currency_list'] = $this->getCurrency();

		print_r($request->input());
		//exit;

        return view('users.user')->with($data)->withErrors($validator)
        																	 ->withInput($request->input());

		echo " aki";
		exit;

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
