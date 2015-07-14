<?php
namespace App\Libraries;
use App\Model\Code as Code;
use Carbon; 


class ValidateCodeTerm implements Ivalidate
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
		$end_date = Carbon::createFromFormat('Y-m-d',$this->db_code->end_date);
		$today	 = Carbon::now();
		if ( $end_date->gte($today) )
		{
			return $this->db_code->end_date;
		}
		$this->error_array[] = 'La vigencia del codigo ha vencido';
		return FALSE;
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