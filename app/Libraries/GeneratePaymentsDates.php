<?php
namespace App\Libraries;

use Carbon; 


class GeneratePaymentsDates 
{
	
	private $inputDate;
	private $tempDate;
	private $toleranceDays;

	public function  __construct($date = FALSE)
	{
		if($date !==FALSE)
		{
			$this->setDate( $date );
		}
		$this->error_array = FALSE;
		$this->toleranceDays = 0;
	}

	public function setDate($date)
	{
		
		$this->inputDate = Carbon::createFromFormat('Y-m-d', $date);
		$this->tempDate = Carbon::createFromFormat('Y-m-d', $date);
	}


	private function checkNextPaymentDate()
	{
		return $this->inputDate->addMonths(1)->toFormattedDateString();  
	}
 

	private function nextBilling()
	{
		return $this->inputDate->addMonths(1)->toDateString();  
	}


	private function checkNumberDays()
	{
		return	$this->tempDate->diffInDays($this->inputDate->copy()->addMonth());
	}


	public function getNextPaymentDate()
	{
		return $this->nextBilling();

	}

	public function getNextPaymentDateHumanRead()
	{
		return $this->checkNextPaymentDate();
	}


	public function getDaysNumberOfNextPaymentDate()
	{
		return (int)($this->checkNumberDays() + $this->toleranceDays);
	}
	
}