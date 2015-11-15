<?php
namespace App\Libraries;

use Carbon; 


class CheckDuePayments
{

	private $startDate;
	private $endDate;
	private $startFormatDate;

	public function __construct()
	{
		$this->today = Carbon::now();
	}


	public function setStartDate($date)
	{
		$this->startFormatDate = $date;
	}



	public function setEndDate($date)
	{
		$this->endDate = Carbon::createFromFormat('Y-m-d', $date);

	}



	private function check_duedates()
	{

		$cont = 0;
		$this->startDate = Carbon::createFromFormat( 'Y-m-d', $this->startFormatDate );
		$monthDays = $this->endDate->daysInMonth;

		while( $this->endDate->gt( $this->startDate->addMonths( $cont ) ) )
		{

			if($cont == 0 && $this->endDate->diffInDays( $this->startDate ) <= $monthDays )
			{
				return 0;
			}
			 
			$this->startDate = Carbon::createFromFormat( 'Y-m-d', $this->startFormatDate );
			$cont++;
		}
	
		return $cont;

	}


	public function getNumberOfDuePayments()
	{
		return $this->check_duedates();
	}

}