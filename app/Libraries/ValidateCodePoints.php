<?php
namespace App\Libraries;
use App\Model\Code as Code;
use Carbon; 


class ValidateCodePoints implements Ivalidate
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
		$temp_points = (int)$this->db_code->points;
		if($temp_points > 0)
		{
			return $temp_points;
		}
		return 0;
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