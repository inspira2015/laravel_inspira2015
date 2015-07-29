<?php
namespace App\Libraries;
use App\Model\Code as Code;
use Carbon; 


class CodesOperations extends CodeValidator
{

	private $usedCode;
	private $codeDao;
	private $userId;

	public function __construct($usedCode, $codeDao)
	{
		parent::__construct();
		$this->usedCode = $usedCode;
		$this->codeDao = $codeDao;
	}
	

	public function setUserId($user_id)
	{
		$this->userId = $user_id;
	}


	private function checkCode()
	{
		if ( !empty( $this->db_code->id ) )
		{
			$this->usedCode->exchangeArray(array('codes_id' => $this->db_code->id, 'users_id' => $this->userId ));
			$this->usedCode->save();
		}
	}


	private function markUsed()
	{
		$this->db_code->used = 1;
		$this->db_code->save();
	}

	public function markCodeUsed()
	{
		$this->markUsed();
	}


	public function saveUsedCode()
	{
		return $this->checkCode();
	}

}