<?php 

namespace App\Model\Dao;

use App\Model\ExchangeRate;

class ExchangeRateDao implements ICrudOperations 
{

	public function getById($id) 
	{
		return ExchangeRate::find($id);
	}

	public function getAll() {
		return ExchangeRate::all();
	}

	public function delete($id) {
		if ($id) 
		{
			$exchange = ExchangeRate::find($id);
			$exchange->delete();
		}
	}
	
	public function save() 
	{
		$id = isset($this->id) ? (int) $this->id : 0;

		$exchange = ExchangeRate::firstOrNew( array( 'id' => $id ));

		foreach($this as $key =>$value)
		{
			$exchange->$key = $value;
		}
		$exchange->save();
		return $exchange->id;
	}

	public function getByDate($date = FALSE, $type)
	{
		return ExchangeRate::where('exchange_date', $date)->where('exchange_type',$type)->get();
	}
}