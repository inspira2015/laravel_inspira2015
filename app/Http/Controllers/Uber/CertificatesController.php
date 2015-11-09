<?php 
namespace App\Http\Controllers\Uber;
use App\Http\Controllers\Controller;
use App\Services\PaymentMethodCC as PaymentValidator;

use Lang;
use Response;
use Session;
use Request;
use Redirect;
use App\Model\Dao\CountryDao;
use App\Model\Dao\StatesDao;

class CertificatesController extends Controller {

	public function getBuyCertificate(){
		if(!Session::get('user')) {
			return Redirect::to('registro');
		}
		return view('uber.buy_certificate')->with( $this->getCCData() )
											->with('title', 'Comprar certificado' )
											->with('background','beach-girl.jpg');
	}
	
	public function postBuyCertificate(){
		$payment = new PaymentValidator();
		$postData = Request::except('_token');
		$validator = $payment->validator( $postData, Lang::locale() );
		if($validator->passes()){
			return Response::json(array(
				'message' => 'Success last step',
				'redirect' => 'http://inspiramexico.leisureloyalty.com'
			), 200);
		}
		return view('uber.buy_certificate_form')->withErrors($validator)
											->with( $this->getCCData() )
											->with('title', 'Comprar certificado' )
											->with('background','beach-girl.jpg');
	}
	
	private function getCCData()
	{
		$locale = Lang::locale();
		return array(  'background' => '2.jpg',
					   'country_list' => $this->getCountryArray($locale),
					   'states' => $this->getStatesArray($locale)
			);
	}
	
	
	protected function getCountryArray($language = FALSE)
	{
		$country = new CountryDao();
		return $country->forSelect('name', 'code');
		
	}
	
	protected function getStatesArray($language = FALSE)
	{
		$states = new StatesDao();
		//default MX - check if its gonna be changed.
		if($language== 'es' || $language==FALSE){
			$country = 'MX';
		}else{
			$country = 'US';
		}
		return $states->forSelect('name', 'code', array('country' => $country ));
	}
}
