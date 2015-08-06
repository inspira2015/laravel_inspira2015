<?php

namespace App\Http\Controllers\CronJobs;
use App\Http\Controllers\Controller;
use Carbon; 
use Request;
use Redirect;
use Response;
use Session;
use Auth;
use App\Model\Entity\ExchangeRateEntity;
use App\Libraries\ApiExchangeRate\CurrentExchangeRate;
use Mail;

class ExchangeRateUpdate extends Controller 
{
	private $exchangeDao;
	protected $auth;
	private $currentExchangeRate;
	private $today;

	
	public function __construct( ExchangeRateEntity $exchange )
	{
		$this->middleware('guest');		
		$this->exchangeDao =  $exchange;
		$this->currentExchangeRate = new CurrentExchangeRate();
		$this->today = Carbon::now();
	}
	

	public function Currentrate()
	{
		
		$dayRate = $this->exchangeDao->getByDate( $this->today->toDateString() , 'USDMXN' )->first();
		$id = 0;
		if ( !empty( $dayRate ) )
		{
			$id = $dayRate->id;
		}

		$currentRate = $this->currentExchangeRate->getExchangeRate();
		$this->exchangeDao->exchangeArray(array( 'id' => $id ,
												 'exchange_type' => 'USDMXN',
												 'exchange_date' => $this->today->toDateString(),
												 'exchange_rate' => $currentRate,
										));
		$this->exchangeDao->save();


		$sent =Mail::send('emails.exchangerate', array( 'day' => $this->today->toFormattedDateString(),
													    'hour' => $this->today->toTimeString(),
													     'exchange' => $currentRate), function($message)
			{
				$today = Carbon::now();
				$dayRate = $this->exchangeDao->getByDate( $today->toDateString() , 'USDMXN' )->first();
				$currentRate = $dayRate->exchange_rate;
		    	$message->to( 'danielgm78@msn.com', 'Daniel GOmez')->subject( 'Exchange USDMXN : ' . $currentRate );
			});

		echo $this->currentExchangeRate->getExchangeRate();


	}
}