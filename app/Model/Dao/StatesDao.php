<?php 

namespace App\Model\Dao;

use App\Model\State;

class StatesDao
{
	public function getById($id) 
	{
		return State::find($id);
	}

	public function getAll() 
	{
		return State::all();
	}
	
	public function forSelect( $key, $def, $filter = null)
	{
		$array = [];
		if($filter){
			$cat = State::where($filter)->lists($key, $def);
		}else{
			$cat = State::lists($key, $def);			
		}
		foreach($cat as $k => $v){ $array[$k] = $v;}
		return ($array);
	}
	
	public function getByCountry( $country = FALSE )
	{
		return State::where( 'country', $country )->get();
	}
	
	public function getNameByCode( $code = FALSE ){
		return State::where( 'code', $code )->first();
	}

}