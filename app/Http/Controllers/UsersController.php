<?php 
namespace App\Http\Controllers;
use Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Validator;

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

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
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
		$data['locale'] = $locale;
		return view('users.user',$data);
	}

	public function registration(Request $request)
	{
		$post_data = $request->all();
		print_r($post_data);
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

}
