<?php
namespace App\Http\Controllers\Landings\Promotions;
use App\Model\Dao\CodeDao;
use App\Http\Controllers\Controller;

use Request;
use Lang;
use Session;
use Input;
use Config;

class PageController extends Controller {
	private $codeDao;
	
	public function __construct(CodeDao $code){
		$this->codeDao = $code;
	}

	public function index()
	{
		$ref_code = Input::get('ref') ? Input::get('ref') : Session::get('ref');
		if(in_array($ref_code,Config::get('extra.promotional')) && !empty( $this->codeDao->getByCode( $ref_code ) ) ){
			$ref = $ref_code;
		}else{
			$ref = 'inspira';
		}
		Session::put('ref', $ref);
		return view('landings.promotions')->with('title', 'Inspira M&eacute;xico | Promociones' )->with('background','3.jpg');
	}
		
	public function goMazatlan(){
		header('Location: http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid=VIIM1346&targetUri=/resortweeks/quickSearch?saved_search=RoRJln63xXF9SOj');
		exit;
	}
	
	public function goPuertoVallarta(){
		header('Location: http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid=VIIM1346&targetUri=/resortweeks/quickSearch?saved_search=8K8lqf3X6AGnBNx');
		exit;
	}
	
	public function goOrlando(){
		header('Location: http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid=VIIM1346&targetUri=/resortweeks/quickSearch?saved_search=Y0mTkfbSEAIzqJj');
		exit;
	}
	
	public function goMalaga(){
		header('Location: http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid=VIIM1346&targetUri=/resortweeks/quickSearch?saved_search=Pe6eaUuRtO8QB0t');
		exit;
	}
	
	public function goDestination(){
		header('Location: http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid=VIIM1346');
		exit;
	}
	
}
