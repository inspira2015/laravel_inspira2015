<?php
namespace App\Libraries\Affiliations;


/*
	|--------------------------------------------------------------------------
	| Final validataion befor user creation
	|--------------------------------------------------------------------------
	|
	| This library stores a User in to the DB
	| 
	|
*/


class ParseCurrencyFromPost
{

	private $storeData;

	public function __construct()
	{
		
	}

	
	public function setAffiliationPost($data = FALSE)
	{
		return $this->checkPost('Affiliation',$data);
	}


	private function checkPost($method,$data)
	{
		if ( $data == FALSE || empty($data) )
		{
			return FALSE;
		}
		$this->storeData[$method] = $data;
		return TRUE;
	}


	private function parse()
	{
		$key = "currency_{$this->storeData['Affiliation']['affiliation']}";
		return $this->storeData['Affiliation'][$key];
	}


	public function getCurrency()
	{
		return $this->parse();
	}


}