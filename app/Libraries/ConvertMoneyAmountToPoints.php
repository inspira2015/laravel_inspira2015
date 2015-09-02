<?php
namespace App\Libraries;
use Carbon; 


/*
	|--------------------------------------------------------------------------
	| Money (MXN Or USD) to Points
	|--------------------------------------------------------------------------
	|
	| This library converts to Points
	| 
	|
*/


class ConvertMoneyAmountToPoints 
{

	private $storeDataArray;
	private $MXNtoPoints;
	private $USDtoPoints;

	public function __construct()
	{
		$this->MXNtoPoints = 10;
		$this->USDtoPoints = 100;
	}


	public function setAmount( $amount = FALSE )
	{
		if ( $amount )
		{
			$this->storeDataArray['amount'] = $amount;
		}
	}

	public function setCurrency( $currency = 'MXN' )
	{
		$this->storeDataArray['currency'] = $currency;
	}


	private function convert()
	{
		if( strcasecmp($this->storeDataArray['currency'], 'MXN') == 0 )
		{
			$points = $this->storeDataArray['amount'] * $this->MXNtoPoints;
		}else{
			$points = $this->storeDataArray['amount'] * $this->USDtoPoints;
		}
		return floor($points);
	}


	public function getPoints()
	{
		return $this->convert();
	}



}