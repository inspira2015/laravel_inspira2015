<?php 
namespace App\Http\Controllers\Uber;
use App\Http\Controllers\Controller;
use App\Services\PaymentMethodCC as PaymentValidator;

use Lang;
use Response;
use Session;
use Request;
use Auth;
use Redirect;
use App\Model\Dao\CountryDao;
use App\Model\Dao\StatesDao;
use App\Model\Entity\UserPaymentInfoEntity as UserPayDao;

class CertificatesController extends Controller {

	public function getBuyCertificate(){
		if(!Session::get('user') ) {
			return Redirect::to('registro');
		}

/*
		if(Auth::check()){
			$usersPayDao = new UserPayDao();
		$payInfo = $usersPayDao->getByUsersId( Auth::user()->id );
		}
*/
		$back_route = (Auth::check()) ? url('/') : url('registro');
		return view('uber.buy_certificate')->with( $this->getCCData() )
											->with('back_route' , $back_route )
											->with('title', 'Comprar certificado' )
											->with('background','beach-girl.jpg');
	}
	
	public function postUseWeek(){
		$user = Auth::user();
		return Response::json(array(
				'error' => false,
				'redirect' => 'http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid='.$user->leisure_id
			), 200);
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
	
	public function newCreditCard(){
		return "clean data";
	}
	
	public function useCreditCard(){
		return "use data";
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
