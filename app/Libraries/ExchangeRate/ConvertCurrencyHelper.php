<?php
namespace App\Libraries\ExchangeRate;



class ConvertCurrencyHelper
{

	private $storeData;


	public function __construct()
	{

	}


	public function setCost($cost)
	{
		if ( !is_numeric( $cost ) )
		{
			$cost = 0;
		}
		$this->storeData['cost'] = $cost;
	}


	public function setCurrencyOfCost($currency)
	{
		$this->storeData['cost_currency'] = $currency;

	}


	public function setRateUSDMXN($rate)
	{
		$this->storeData['RateUSDMXN'] = $rate;

	}


	public function setCurrencyShow($currency)
	{
		$this->storeData['show_currency'] = $currency;
	}


	public function getCurrencyShow()
	{
		return $this->storeData['show_currency'];
	}


	private function convert()
	{
		if( $this->storeData['cost_currency'] == $this->storeData['show_currency'] )
		{
			$exchangeRate = 1;
		}
		
		if( $this->storeData['cost_currency'] == "USD" &&  $this->storeData['show_currency'] == "MXN" )
		{
			$exchangeRate = (float)$this->storeData['RateUSDMXN'];
		}

		if( $this->storeData['cost_currency'] == "MXN" &&  $this->storeData['show_currency'] == "USD" )
		{
			$exchangeRate = (1 / $this->storeData['RateUSDMXN']);
		}

		return $this->storeData['cost'] * $exchangeRate;
	}



	public function getConvertAmount()
	{
		return $this->convert();
	}



}