<?php
namespace App\Libraries\ExchangeRate;
use App\Model\Entity\ExchangeRateEntity;
use Carbon; 


/*
	|--------------------------------------------------------------------------
	| Final validataion befor user creation
	|--------------------------------------------------------------------------
	|
	| This library stores a User in to the DB
	| 
	|
*/


class ExchangeMXNUSD implements IExchange
{
	private $exchangeDao;
	private $today;

	public function __construct(ExchangeRateEntity $exchange)
	{
		$this->exchangeDao = $exchange;
		$this->today = $this->checkToday();
	}


	private function checkToday()
	{
		$tempDate = Carbon::now();
		if ( $tempDate->isWeekend() )
		{
			$tempDate = new Carbon('last friday');
		}

		return $tempDate->toDateString();
	}


	public function getToday()
	{
		return $this->today;
	}


	private function ValidRate($date)
	{
		list($year,$month,$day) = explode('-',$date);
		$temporalDate = Carbon::createFromDate($year,$month,$day);
		$i = 0;
		do
		{
			if($i == 100)
			{
				break;
			}
			$rate = $this->exchangeDao->getByDate( $temporalDate->toDateString() , 'USDMXN' )->first();
			$temporalDate->subWeekday();
			$i++;

		}while (!$rate);

		return $rate->exchange_rate;
	}


	public function getTodayRate()
	{
		return $this->ValidRate($this->today);
	}

	public function getRate($date = FALSE)
	{
		if ($date == FALSE)
		{
			throw new Exception('Invalid Date');
		}
		return $this->ValidRate($date);
	}

}