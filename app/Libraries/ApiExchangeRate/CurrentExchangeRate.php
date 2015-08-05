<?php
namespace App\Libraries\ApiExchangeRate;
use WebservicexApi;
use OpenExchangeRatesApi;

/*
	|--------------------------------------------------------------------------
	| CurrentExchangeRate
	|--------------------------------------------------------------------------
	|
	| This library its use by the view to populate with correct data
	| 
	|
*/

class CurrentExchangeRate
{

	private $webServcx;
	private $openExch;
	private $currentRate;

	public function __construct()
	{
		$this->webServcx = new WebservicexApi();
		$this->openExch = new OpenExchangeRatesApi();
		$this->currentRate = FALSE;
	}


	private function checkApi()
	{
		$currentRate = $this->webServcx->getCurrentRate();
		if( $currentRate == FALSE )
		{
			$currentRate = $this->openExch->getCurrentRate();
		}
		if($currentRate)
		{
			$this->currentRate = $currentRate;
			return TRUE;
		}
		return FALSE;
	}


	private function ValidateRate()
	{
		for ( $i =0; $i < 2000; $i++ )
		{
			if( $this->checkApi())
			{
				break;
			}
		}

	}


	public function getExchangeRate()
	{
		$this->ValidateRate();
		return $this->currentRate;
	}



}