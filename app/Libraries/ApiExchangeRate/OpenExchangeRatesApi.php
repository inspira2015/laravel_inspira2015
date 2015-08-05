<?php
namespace App\Libraries\ApiExchangeRate;


/*
	|--------------------------------------------------------------------------
	| OpenExchangeRates
	|--------------------------------------------------------------------------
	|
	| This library uses Curl to get USD MXN Rate
	| 
	|
*/

class OpenExchangeRatesApi implements IApiConsumption
{

	public function __construct()
	{

	}

	private function checkApi()
	{
		$headers = array( 'Content-Type: application/json' );
		$fields = array(
    		'app_id' => '1c01828c30da413792ad387b78fb13bf'
		);
		$url = 'https://openexchangerates.org/api/latest.json?' . http_build_query($fields);
		$ch = curl_init();

		// Set the url, number of GET vars, GET data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$result_arr = json_decode($result, true);
		if ( empty( $result_arr ) )
		{
			return FALSE;
		}

		$rate = (float)$result_arr['rates']['MXN'];
		return $rate;
	}


	public function getCurrentRate()
	{
		return $this->checkApi();
	}
	


	public function getApiService()
	{
		return 'OpenExchangeRates';
	}

}