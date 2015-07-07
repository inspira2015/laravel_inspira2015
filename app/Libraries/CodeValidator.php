<?php
namespace App\Libraries;
use App\Model\Code as Code;
use Carbon; 


class CodeValidator
{

	private $objValidate;
	private $db_code;

	public function __construct()
	{
		$this->objValidate['Term'] = new ValidateCodeTerm();
		$this->objValidate['Affiliations'] = new ValidateCodeAffiliations();
		$this->objValidate['Points'] = new ValidateCodePoints();
		$this->objValidate['Use'] = new ValidateCodeUse();
	}

	public function setCode(Code $code)
	{
		$this->db_code = $code;
		foreach($this->objValidate as &$obj)
		{
			$obj->setCode($this->db_code );
		}
	}

	public function checkValid()
	{
		if( $this->objValidate['Term']->checkValid() &&  $this->objValidate['Use']->checkValid() )
		{
			return TRUE;
		}
		return FALSE;
	}


	public function __call($name,$arguments)
	{
		$obj = ltrim($name, 'get');
		if( strcasecmp($arguments,'errors') == 0 ||
		    strcasecmp($arguments,'error') == 0 )
		{
			return $this->objValidate[$obj]->getErrors();
		}

		return $this->objValidate[$obj]->checkValid();
	}


}