<?php
namespace App\Libraries\ApiExchangeRate;


/*
	|--------------------------------------------------------------------------
	| WebservicexApi
	|--------------------------------------------------------------------------
	|
	| This library uses Curl to get USD MXN Rate
	| 
	|
*/

class WebservicexApi implements IApiConsumption
{

	public function __construct()
	{

	}

	private function checkApi()
	{
		$headers = array( 'Content-Type: text/plain' );
		$fields = array(
    					'FromCurrency' => 'USD',
    					'ToCurrency' => 'MXN',
					);
		$url = 'www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?' . http_build_query($fields);
		$ch = curl_init();

		// Set the url, number of GET vars, GET data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		curl_close($ch);
		$xmlRate = simplexml_load_string($result) or die("Error: Cannot create object");
		$xmlarray = (array)$xmlRate;
		if ( empty( $xmlarray ) )
		{
			return FALSE;
		}
		$rate = (float)$xmlarray[0];
		return $rate;
	}


	public function getCurrentRate()
	{
		return $this->checkApi();
	}
	


	public function getApiService()
	{
		return 'WebservicexApi';
	}

}