<?php
namespace App\Libraries\Affiliations;


/*
	|--------------------------------------------------------------------------
	| AffiliationViewObject
	|--------------------------------------------------------------------------
	|
	| This library its use by the view to populate with correct data
	| 
	|
*/

class AffiliationViewObject 
{
	private $languaje;
	private $storeData;

	public function __construct()
	{
		//$this->setLang();
		$this->setCurrency();
	}

	public function setLang($lang = 'es')
	{
		$this->languaje = $lang;
	}

	public function setCurrency($currency = 'MXP')
	{
		$this->storeData['currency'] = $currency;
	}

	public function setAffiliationPrice($price = FALSE)
	{
		$this->storeData['AffiliationPrice'] = (int)$price;
	}

	public function setAffiliationDB($affiliation)
	{
		$this->storeData['AffiliationDB'] = $affiliation;
	}

	public function setAffiliationDescription($affdescription)
	{
		$this->storeData['AffiliationDescription'] = $affdescription;
	}



	public function getAffiliationName()
	{
		if( strcasecmp( $this->languaje, 'es' ) == 0 )
		{
			return $this->storeData['AffiliationDB']->name_es;
		}
		return $this->storeData['AffiliationDB']->name_eng;
	}


	public function getAffiliationSmallDesc()
	{
		if( strcasecmp( $this->languaje, 'es' ) == 0 )
		{
			return $this->storeData['AffiliationDB']->small_desc_es;
		}
		return $this->storeData['AffiliationDB']->small_desc_eng;
	}

	public function getAffiliationPrice()
	{
		return $this->storeData['AffiliationPrice'];
	}

	public function getCurrency()
	{
		return $this->storeData['currency'];
	}

	public function getAffiliationId()
	{
		return $this->storeData['AffiliationDB']->id;
	}


	private function checkAffiliationDesc()
	{
		$temp = $this->storeData['AffiliationDB']->affiliations_description->toArray();
		$description = array();
		$i = 0;
		foreach($temp as $key =>$value)
		{
			$description[$i]['id'] = $value['id'];
			$description[$i]['affiliations_id'] = $value['affiliations_id'];

			if( strcasecmp( $this->languaje, 'es' ) == 0 )
			{
				$description[$i]['description'] = $value['description_es'];
			}
			else
			{
				$description[$i]['description'] = $value['description_eng'];
			}
			$i++;
		}
		return $description;
	}

	public function getAffDescriptionArray()
	{
		return $this->checkAffiliationDesc();
	}

}