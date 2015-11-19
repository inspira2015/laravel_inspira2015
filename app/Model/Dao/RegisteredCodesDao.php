<?php 

namespace App\Model\Dao;

use App\Model\RegisteredCodes;

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
			$registeredCode->$key = $value;
		}
		$registeredCode->save();
		return $registeredCode->id;
	}
	
	

}