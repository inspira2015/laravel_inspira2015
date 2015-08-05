<?php

namespace App\Libraries\ApiExchangeRate;

interface IApiConsumption 
{
	
	public function getCurrentRate();
	public function getApiService();
}