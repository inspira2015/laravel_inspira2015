<?php 
namespace App\Http\Controllers;
use Auth;
use App\Model\Dao\UserDao;
use App\Model\Dao\UserRegisteredPhoneDao;

class UseraccountController extends Controller {

	private $userDao;
	private $phoneDao;
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
	 
	public function __construct( UserDao $userDao, UserRegisteredPhoneDao $phoneDao)
	{
		$this->middleware('auth');
		$this->userDao = $userDao;
		$this->phoneDao = $phoneDao;
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = new \stdClass();
		$phones = new \stdClass();
		
		$phones->cellphone = $this->userDao->getPhoneType( Auth::user()->id, 'cellphone');
		$phones->phone = $this->userDao->getPhoneType( Auth::user()->id, 'phone');
		$phones->office = $this->userDao->getPhoneType( Auth::user()->id, 'office');
		
		$user->details = $this->userDao->getById( Auth::user()->id );
		$user->phones = $phones;
		$user->address = $this->userDao->getAddress( Auth::user()->id );
		
		return view('useraccount.userdata')->with( 'user' , $user );

	}

}
