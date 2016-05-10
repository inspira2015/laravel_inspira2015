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
		$ref_code = strtolower($ref_code);
		if(in_array($ref_code,Config::get('extra.promotional')) && !empty( $this->codeDao->getByCode( $ref_code ) ) ){
			$ref = $ref_code;
		}else{
			$ref = 'inspira';
		}
		
		$modal = Session::get('logged_user') ? true : false;
		Session::put('ref', $ref);
		return view('landings.promotions')->with('title', 'Inspira M&eacute;xico | Promociones' )->with('background','3.jpg')->with('modal', $modal);
	}
		
	public function goMazatlan(){
		header('Location: '.$this->getSearch('RoRJln63xXF9SOj'));
		exit;
	}
	
	public function goPuertoVallarta(){
		header('Location: '.$this->getSearch('8K8lqf3X6AGnBNx'));
		exit;
	}
	
	public function goOrlando(){
		header('Location: '.$this->getSearch('Y0mTkfbSEAIzqJj'));
		exit;
	}
	
	public function goMalaga(){
		header('Location: '.$this->getSearch('Pe6eaUuRtO8QB0t'));
		exit;
	}
	
	public function goManzanillo(){
		header('Location: '.$this->getSearch('wWaxDP24eaLp01h'));
		exit;
	}
	
	public function goLasVegas(){
		header('Location: '.$this->getSearch('Uzitc91Hy7FJKPQ'));
		exit;
	}
	
	public function goCostaRica(){
		header('Location: '.$this->getSearch('SkYvjf2QVKYbq6h'));
		exit;
	}
	
	public function goDestination(){
		header('Location: '.$this->getSearch());
		exit;
	}
	

	private function getSearch($search = null){
		if(Input::get('u')) {
			$mid = 'VIIM1346';
		}else{
			$mid = Input::get('lang') ? 'VIIM00243' : 'VIIM00242';
		}
		return "http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid={$mid}&targetUri=/resortweeks/quickSearch?saved_search={$search}";
	}
	
}
