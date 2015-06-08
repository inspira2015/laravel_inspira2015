<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Validator;

use App\Model\Dao\CodeDao;

class CodesController extends Controller {

	private $codeDao;

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
	public function __construct(CodeDao $dao)
	{
		$this->middleware('guest');
		$this->codeDao = $dao;
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function Index()
	{
		return view('codes.code');
	}
	
	/**
	 * Check if user input a code if its exist or not
	 *
	 * @return Response
	 */
	public function Check(Request $request)
	{
		$post_data = $request->all();

		print_r($post_data);

		$code_data = $this->codeDao->getById(1);


		print_r($code_data );

		$validator = Validator::make($post_data,array('code' => 'required'));

		if($validator->fails())
		{
			echo "fallo";
			exit;
		}

	}

	

}
