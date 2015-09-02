<?php

namespace App\Libraries\SystemTransactions;
use App\Model\Code as Code;
use Carbon; 
use App\Model\Entity\SystemTransactionEntity;
use App\Model\Dao\UserDao;


class SetBillableDate extends AbstractTransactions 
{
	private $db_code;
	private $error_array;
	private $valid;
	private $userDao;
	private $userPaymentArray;
	private $today;

	public function  __construct( SystemTransactionEntity $systemTransactions,
								  UserDao $userDao )
	{
		parent::__construct( $systemTransactions );
		$this->userDao = $userDao;
		$this->today = Carbon::now();
	}

	

	private function checkDay()
	{
		$temp_day = (int)$this->today->day;
		if ( $temp_day == 31 )
		{
			return 30;
		}
		return $temp_day;
	}

	public function saveData()
	{
		$user = $this->userDao->getById( $this->objUser->id );
		if ( empty($user->billable_day) )
		{
			$this->saveTransaction();
			$user->billable_day = $this->checkDay();
			$user->save();
			return TRUE;
		}

		return FALSE;
	}

	public function getErrors()
	{
		return TRUE;
	}
}