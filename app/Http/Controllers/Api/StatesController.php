<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Request;
use Redirect;
use Response;
use Session;
use Auth;
use App\Model\Dao\StatesDao;

class StatesController extends Controller 
{
	private $statesDao;
	protected $auth;
	
	public function __construct( StatesDao $statesDao )
	{
		$this->statesDao =  $statesDao;
	}
	
	public function getByCountryCode(){
		$country = Request::get('country');
		return Response::json(array(
			'error' => false,
			'data' => $this->statesDao->getByCountry($country)
		), 200);
	}
}