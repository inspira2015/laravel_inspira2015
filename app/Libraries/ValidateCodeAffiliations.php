<?php
namespace App\Libraries;
use App\Model\Code as Code;
use Carbon; 


class ValidateCodeAffiliations implements Ivalidate
{
	private $db_code;
	protected $error_array;
	private $valid;
	protected $affiliations;

	public function  __construct()
	{
		$this->affiliations = array('discover','bronze','gold','platinum','diamond');
		$this->error_array = FALSE;
	}

	public function setCode(Code $code)
	{
		$this->db_code = $code;

	}
	
	private function check()
	{
		$valid_array = array();
		$i =0;
		foreach($this->affiliations as $value)
		{
			if($this->db_code->$value >= 0)
			{
				$valid_array[$i][$value] = $this->db_code->$value;
				$valid_array[$i]['currency'] = $this->db_code->currency;

				$i++;
			}
		}
		return $valid_array;
	}

	public function checkValid()
	{
		return $this->check();
	}

	public function getErrors()
	{
		$this->check();
		return $this->error_array;
	}
}