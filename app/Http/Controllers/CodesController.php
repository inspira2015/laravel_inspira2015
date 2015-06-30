<?php 
namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Model\Dao\CodeDao;

class CodesController extends Controller {

	private $codeDao;

	public function __construct(CodeDao $dao) {
		$this->middleware('guest');
		$this->codeDao = $dao;
	}

	public function Index() {
		return view('codes.view')->with('title', 'Ingresa tu c&oacute;digo' );
	}

	public function Check(Request $request) {

		$code_data = $this->codeDao->getById(1);
		echo "<pre>";
		print_r($code_data);
		echo "</pre>";
				
		$validator = Validator::make($request->all(), [
            'code' => 'required'
        ]);

        if ($validator->fails()) {
            return "Fallo :(";
        }else{
	        return "Paso!! :D";
        }
	}


}
