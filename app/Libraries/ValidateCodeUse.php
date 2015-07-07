<?php
namespace App\Libraries;
use App\Model\Code as Code;
use Carbon; 


class ValidateCodeUse implements Ivalidate
{
	private $db_code;
	private $error_array;
	private $valid;

	public function  __construct()
	{
		$this->error_array = FALSE;
	}

	public function setCode(Code $code)
	{
		$this->db_code = $code;

	}
	
	private function check()
	{
		$reuse = (int)$this->db_code->reuse;
		$used = (int)$this->db_code->used;

		if ( $reuse )
		{
			return TRUE;
		}
		else if ( $reuse ==0 & $used ==1 )
		{
			return TRUE;
		}
		else if ( $reuse == 0 & $used == 0)
		{
			return FALSE;
		}
		return FALSE;

	}

	public function checkValid()
	{
		return $this->check();
	}

	public function getErrors()
	{
		return array('El Codigo ya fue usado y no admite reuso');
	}
}