<?php
namespace App\Libraries;

use Carbon; 


class GeneratePaymentsDates 
{
	
	private $inputDate;
	private $tempDate;
	private $toleranceDays;
	private $billDay;

	public function  __construct($date = FALSE)
	{
		if($date !==FALSE)
		{
			$this->setDate( $date );
		}
		$this->error_array = FALSE;
		$this->toleranceDays = 0;
		$this->billDay = FALSE;
	}

	public function setDate( $date )
	{
		
		$this->inputDate = Carbon::createFromFormat('Y-m-d', $date);
		$this->tempDate = Carbon::createFromFormat('Y-m-d', $date);
	}

	public function setBillableDay($day)
	{
		$this->billDay = $day;
	}


	private function checkNextPaymentDate()
	{
		if( $this->billDay!==FALSE && is_numeric( $this->billDay ) )
		{
			$this->inputDate->day = $this->billDay;
		}
		

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


	private function carbonNextPayment()
	{
		$date = $this->getNextPaymentDate();
		return Carbon::createFromFormat('Y-m-d', $date);
	}



	public function getNextPaymentCarbonDate()
	{
		return $this->carbonNextPayment();
	}


	public function getDaysNumberOfNextPaymentDate()
	{
		return (int)($this->checkNumberDays() + $this->toleranceDays);
	}
	
}