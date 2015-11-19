<?php 

namespace App\Model\Dao;

use App\Model\RegisteredCodes;
use DB;

class RegisteredCodesDao
{
	public function getById($id) 
	{
		return RegisteredCodes::find($id);
	}

	public function getAll() 
	{
		return RegisteredCodes::all();
	}
	
	
	public function load( $id )
	{

		$this->populate( $this->getById( $id ) );
	}

	private function populate( $row )
 	{
 		foreach($row->toArray() as $key => $value)
 		{
 			$this->$key = $value;
 		}
 	}
	
	public function save() 
	{
		$id = isset($this->id) ? (int) $this->id : 0;

		$registeredCode = RegisteredCodes::firstOrNew( array( 'id' => $id ));
		foreach($this as $key =>$value)
		{
			if($key == 'expiration_date' ) 
				$registeredCode->$key = DB::raw('NOW() + INTERVAL '.$value.' DAY');
			else
				$registeredCode->$key = $value;

		}
		$registeredCode->save();
		return $registeredCode->id;
	}
	
	
	public function getLastActivated( $users_id ){
		return RegisteredCodes::where('status', 'Active')->where('users_id' , $users_id)->orderBy('expiration_date' , 'asc')->first();
	}

}