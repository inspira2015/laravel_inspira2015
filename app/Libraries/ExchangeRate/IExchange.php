<?php
namespace App\Libraries\ExchangeRate;


interface IExchange 
{
	public function getTodayRate();
	public function getRate($date);

}