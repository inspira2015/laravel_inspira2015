<?php 

namespace App\Model\Dao;

use App\Model\Country;

class CountryDao
{
	public function getById($id) 
	{
		return Country::find($id);
	}

	public function getAll() 
	{
		return Country::all();
	}

	public function forSelect($key, $def)
	{
		$cat = Country::lists($key, $def);
		foreach($cat as $k => $v){ $array[$k] = $v;}
		return ($array);
	}
	
	public function getNameByCode( $code )
	{
		return $this->getCountryByCode( $code )->name;	
	}
	
	public function getCountryByCode( $code )
	{
		return Country::where('code', $code)->first();
	}

}