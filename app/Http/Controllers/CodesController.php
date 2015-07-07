<?php  namespace App\Http\Controllers;
use Request;
use Redirect;
use Carbon; 
use Session;
use App\Model\Dao\CodeDao;
use App\Model\Code;
use App\Services\ServiceCode as ServiceCode;
use App\Libraries\CodeValidator as CodeValidator;

class CodesController extends Controller {

	private $codeDao;
	private $objtest;

	public function __construct(CodeDao $dao) 
	{
		$this->middleware('guest');
		$this->codeDao = $dao;
		$this->check = new CodeValidator();
	}

	public function Index() 
	{
		return view('codes.view')->with('title', 'Ingresa tu c&oacute;digo' );
	}

	public function Check() 
	{
		$data = Request::all();
		$validator = ServiceCode::validator($data);
		
        if ( $validator->passes() ) 
        {
			$code = $this->codeDao->getByCode($data['code'])->first();
			$this->check->setCode($code);

			if ( $this->check->checkValid() )
			{
				Session::put('code', $code);
				return Redirect::to('users');
			}

			return Redirect::back()->with('title', 'Ingresa tu c&oacute;digo' )->withErrors(array('message' => 'Code is not valid'));
        }
        
        return Redirect::back()->with('title', 'Ingresa tu c&oacute;digo' )->withErrors($validator);
	}
	
	public function GetValid( $code ){
		if( $code->end_date >= Carbon::today() )
		{
			return true;
		}
		return false;
	}
	
	public function getError()
	{
		
	}

}
