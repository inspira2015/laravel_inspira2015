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

class AffiliationsColorCodes
{
	private $colorCodes;


	public function __construct()
	{
		$this->colorCodes = array(
									'DISCOVER' => '#529ad3',
									'PLATINUM' => '#a4ce3a',
									'DIAMOND' => '#cc4b9b',
									'INSPIRA CARD' => '#ea732d',
									'VIP CARD' => '#2d383f',
									
									'DESCUBRE' => '#529ad3',
									'PLATINO' => '#a4ce3a',
									'DIAMANTE' => '#cc4b9b',
									'TARJETA INSPIRA' => '#ea732d',
									'TARJETA VIP' => '#2d383f'
			);

	}
	public function __call($method, $args)
	{
		return $this->__get($method);
	}

	public function __get($aff_english)
	{
		if ( array_key_exists( $aff_english, $this->colorCodes )  )
		{
			return $this->colorCodes[ $aff_english ];
		}
		return $this->colorCodes[ 'DISCOVER' ];
	}

}