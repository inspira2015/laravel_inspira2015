<?php

namespace App\Http\Controllers\CronJobs;
use App\Http\Controllers\Controller;

use Request;
use Redirect;
use Response;
use Session;
use Auth;
use App\Model\Entity\ExchangeRateEntity;
use App\Libraries\ApiExchangeRate\CurrentExchangeRate;

class ExchangeRateUpdate extends Controller 
{
	private $exchangeDao;
	protected $auth;
	
	public function __construct( ExchangeRateEntity $exchange )
	{
		$this->middleware('guest');		
		$this->exchangeDao =  $exchange;
	}
	

	public function Currentrate()
	{
		









		return Response::json(array(
			'error' => false,
			'data' => 'test'
		), 200);

	}
}