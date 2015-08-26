<?php
namespace App\Libraries;
use App\Libraries\InitializePayUCredentials;
use Carbon; 
use GeoIP;
use App\Libraries\PayU;
use App\Libraries\PayU\api\SupportedLanguages;
use App\Libraries\PayU\util\PayUParameters;
//use App\Libraries\PayU\PayUTokens;
use App\Libraries\PayU\api\PayUCountries;
use App\Libraries\PayU\PayUPayments;
use App\Libraries\PayU\PayUReports;


/*
	|--------------------------------------------------------------------------
	| Final validataion befor user creation
	|--------------------------------------------------------------------------
	|
	| This library stores a User in to the DB
	| 
	|
*/


class CashOrder extends InitializePayUCredentials
{

	private $orderData;
	private $errorArray;
	private $parameters;
	private $response;


	public function __construct()
	{
		parent::__construct();
	}

	public function setOrderData( $data )
	{
		$this->orderData = $data;
	}

	private function validateOrderReport()
	{
		if( empty( $this->orderData ) )
		{
			$this->errorArray[] = "No hay suficientes datos de usuario";
			return FALSE;
		}

		$parameters = array(
			PayUParameters::ORDER_ID => $this->orderData['orderId']
			
		);
		$this->parameters = $parameters;
		return TRUE;
	}

	public function checkOrderData()
	{
		return $this->validateOrderReport();
	}
	
	private function checkOrderStatus()
	{
		
		$response = PayUReports::getOrderDetail($this->orderData);    

		if( $response->code == 'SUCCESS' )
		{
			$this->response = $response;
			return TRUE;
		}
		else
		{
			$this->errorArray[] = $response->error;
			return FALSE;
		}

	}

	public function getErrors()
	{
		return $this->errorArray;
	}

	public function doRequest()
	{
		return $this->checkOrderStatus();
	}

	public function getResponse()
	{
		return $this->response;
	}

}