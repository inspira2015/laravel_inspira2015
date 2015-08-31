<?php  namespace App\Http\Controllers;
use Request;
use Redirect;
use Carbon; 
use Session;
use App\Model\Dao\CodeDao;
use App\Model\Code;
use App\Services\ServiceCode as ServiceCode;
use App\Libraries\CodeValidator as CodeValidator;
use Input;


class CodesController extends Controller {

	private $codeDao;
	private $objtest;

	public function __construct(CodeDao $dao) 
	{
		$this->middleware('guest');
		$this->codeDao = $dao;
		$this->check = new CodeValidator();
		$this->setLanguage();
	}

	public function Index($reset = FALSE) 
	{
		if( $reset == FALSE )
		{
			$this->deleteSessionData();
			Session::regenerate();
			Session::put('registrySession', $this->rand_string( 8 ) );
		}
		$code = '';
		if ( Session::has('code') )
		{			
			$code = Session::get('code');
		}
			return view('codes.view')->with('title', 'Ingresa tu c&oacute;digo' )
									 ->with('background','codigo-background.jpg')
									 ->with('code',$code);

		

		return view('codes.view')->with('title', 'Ingresa tu c&oacute;digo' )->with('background','codigo-background.jpg');
	}

	public function Check() 
	{
		$data = Request::all();
		$validator = ServiceCode::validator($data);
		
        if ( $validator->passes() ) 
        {
			$code = $this->codeDao->getByCode( $data['code'] )->first();
			if(!empty($code)){
				$this->check->setCode($code);
	
				if ( $this->check->checkValid() )
				{
					Session::put('code', $data['code']);
					return Redirect::to('users');
				}				
			}
			return Redirect::back()->with('title', 'Ingresa tu c&oacute;digo' )->with('background','codigo-background.jpg')->withErrors(array('message' => 'Code is not valid'));
        }
        Session::put('code', 'default');
        return Redirect::back()->with('title', 'Ingresa tu c&oacute;digo' )->with('background','codigo-background.jpg')->withErrors($validator);
	}


	public function Continuenocode()
	{


		Session::put('code', 'default');
		return Response::json(array(
				'error' => false,
				'redirect' => url('users')
			), 200);
	}
	

	public function GetValid( $code ){
		if( $code->end_date >= Carbon::today() )
		{
			return true;
		}
		return false;
	}


	private  function rand_string( $length ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

		$size = strlen( $chars );
		$str = '';
		for( $i = 0; $i < $length; $i++ ) 
		{
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}
	
	
}
