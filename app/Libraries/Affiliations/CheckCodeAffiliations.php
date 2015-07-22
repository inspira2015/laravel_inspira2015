<?php
namespace App\Libraries\Affiliations;
use Lang;


use App\Model\User;
use App\Model\Entity\UserVacationalFunds;
use App\Model\Entity\Affiliations;
use App\Model\Dao\CodeDao;

use App\Libraries\ValidateCodeAffiliations;


/*
	|--------------------------------------------------------------------------
	| CheckCodeAffiliations
	|--------------------------------------------------------------------------
	|
	| This library check codes Affiliations and setup a new AffiliationViewObject
	| 
	|
*/

class CheckCodeAffiliations 
{
	private $objUser;
	private $affiliations;
	private $usersVacDao;
	private $checkCodeVal;
	private $codeDao;
	private $userCode;

	/**
	 * Initialize Dao Models - 
	 *
	 * @return void
	 */
	public function  __construct(Affiliations $affiliations,CodeDao $code )
	{
		$this->affiliations = $affiliations;
		$this->codeDao = $code;

	}

	/**
	 * Set Users Id
	 *
	 * @return void
	 */
	public function setCode($code)
	{
		$this->userCode = $code;
	}



	private function check()
	{
		$obj = $this->checkAffiliations();
		return $obj->checkValid();

	}

	public function checkAffiliations()
	{

		$code = $this->codeDao->getByCode( $this->userCode )->first();

		
		$objValidateAff = new ValidateCodeAffiliations();
		$objValidateAff->setCode( $code );
		return $objValidateAff;
	}



	private function convertObject()
	{
		$suscription = array();
		$aff_array = $this->check();

		foreach($aff_array as $key => $value)
		{
			$affiliation = key( $value );
			$obj = new AffiliationViewObject();
			$obj->setLang( Lang::getLocale() );
			$obj->setCurrency( $value[ 'currency' ] );
			$obj->setAffiliationPrice( $value[ $affiliation ] );
			$obj->setAffiliationDB( $this->affiliations->getByNameEng( $affiliation ) );
			$obj->setAffiliationDescription( $this->affiliations->getByNameEng( $affiliation ) );
			$suscription[] = $obj;
		}
		return $suscription;
	}

	public function getAffiliationObjectArray()
	{
		return $this->convertObject();
	}


}