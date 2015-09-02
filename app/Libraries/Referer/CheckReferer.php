<?php
namespace App\Libraries\Referer;


/*
	|--------------------------------------------------------------------------
	| AffiliationViewObject
	|--------------------------------------------------------------------------
	|
	| This library its use by the view to populate with correct data
	| 
	|
*/

class CheckReferer
{

	private $validUrl;
	private $refererUrl;


	public function __construct()
	{

	}

	public function setRefererUrl($referer)
	{
		$this->refererUrl = $referer;
	}

	public function setValidUrl($url)
	{
		$this->validUrl[] = $url;
	}
	
	private function check()
	{
		foreach( $this->validUrl as $url )
		{
			if (strpos( $this->refererUrl, $url ) !== false) 
			{

   				return TRUE;
			}
		}
		return FALSE;
	}


	public function checkValid()
	{
		return $this->check();
	
	}

}