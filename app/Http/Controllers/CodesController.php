<?php 
namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Model\Dao\CodeDao;
use App\Services\ServiceCode as ServiceCode;


class CodesController extends Controller {

	private $codeDao;

	public function __construct(CodeDao $dao) {
		$this->middleware('guest');
		$this->codeDao = $dao;
	}

	public function Index() {
		return view('codes.view')->with('title', 'Ingresa tu c&oacute;digo' );
	}

	public function Check(Request $request, ServiceCode $service) {
		$data = $request->all();
		$code_data = $this->codeDao->find(1);

		$validator = $service->validator($data);
		
        if ($validator->passes()) {
		//What happens if it success.
			return view('codes.success')->with('title', 'C&oacute;digo registrado');
        }
        return view('codes.view')->with('title', 'Ingresa tu c&oacute;digo' )->withErrors($validator);
	}


}
