<?php
namespace App\Libraries;

use Carbon; 


class GeneratePaymentsDates 
{
	
	private $inputDate;

	public function  __construct()
	{
		$this->error_array = FALSE;
	}

	public function setDate($date)
	{
		
		$this->inputDate = Carbon::createFromFormat('Y-m-d', $date);

	}





	private function checkNextPaymentDate()
	{
		return $this->inputDate->addMonths(1)->toFormattedDateString();  
	}
 

	private function nextBilling()
	{
		return $this->inputDate->addMonths(1)->toDateString();  
	}

	public function getNextPaymentDate()
	{
		return $this->nextBilling();

	}

	public function getNextPaymentDateHumanRead()
	{
		return $this->checkNextPaymentDate();

	}
	
}