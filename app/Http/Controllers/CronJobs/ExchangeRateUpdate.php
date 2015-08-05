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
	private $currentExchangeRate;
	
	
	public function __construct( ExchangeRateEntity $exchange )
	{
		$this->middleware('guest');		
		$this->exchangeDao =  $exchange;
		$this->currentExchangeRate = new CurrentExchangeRate();
	}
	

	public function Currentrate()
	{
		
		echo $this->currentExchangeRate->getExchangeRate();








		return Response::json(array(
			'error' => false,
			'data' => 'test'
		), 200);

	}
}