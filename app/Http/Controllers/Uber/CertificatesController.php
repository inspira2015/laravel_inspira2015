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

		$usersPayDao = new UserPayDao();
		$payInfo = $usersPayDao->getByUsersId( Auth::user()->id );
		return view('uber.certificates.buy_certificate')->with('cc', $payInfo)
											->with( $this->getCCData() )
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
				'error' => false,
				'html' => htmlspecialchars(view('uber.certificates.success_payment')),
				'redirect' => url('/')
			), 200);
		}
		return view('uber.certificates.buy_certificate_form')->withErrors($validator)
											->with( $this->getCCData() )
											->with('title', 'Comprar certificado' )
											->with('background','beach-girl.jpg');
	}
	
	public function newCreditCard(){
		return Response::json(array(
			'error' => false,
			'redirect' => '/comprar-certificado'
		), 200);
	}
	
	public function useCreditCard(){
		$usersPayDao = new UserPayDao();
		$payInfo = $usersPayDao->getByUsersId( Auth::user()->id )->first();
		$data = array(
			'name_on_card' => $payInfo->name_on_card,
			'state' => $payInfo->state,
			'city' => $payInfo->city,
			'zip_code' => $payInfo->zip_code,
			'address' => $payInfo->address,
			'birthdate' => date("Y/m/d", strtotime($payInfo->birthdate))
		);
		return view('uber.certificates.buy_certificate_form')->with($data)
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
