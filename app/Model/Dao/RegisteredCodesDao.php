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
			$registeredCode->$key = $value;

			if($key == 'expiration_date' && is_int($value) ) {
				$registeredCode->$key = DB::raw('NOW() + INTERVAL '.$value.' DAY');
			}

		}
		$registeredCode->save();
		return $registeredCode->id;
	}
	
	public function setExpired( $users_id ){
		return RegisteredCodes::where('status', 'Active')->where('users_id' , $users_id)->where('expiration_date', '<', date('Y-m-d H:i:s') )->update( array('status' => 'Expired'));
	}
	
	public function getActive( $users_id ){
		return RegisteredCodes::where('status', 'Active')->where('users_id' , $users_id)->where('expiration_date', '>=', date('Y-m-d H:i:s') )->get();
	}
	
	public function getActiveExpired( $users_id ){
		return RegisteredCodes::where('status', 'Active')->where('users_id' , $users_id)->where('expiration_date', '<', date('Y-m-d H:i:s') )->get();
	}
	
	public function getNotExpired( $users_id ){
		return RegisteredCodes::where('users_id' , $users_id)->where('expiration_date', '>=', date('Y-m-d H:i:s') )->where('status', '!=', 'Expired')->get();

	}
	public function getLastActivated( $users_id ){
		return RegisteredCodes::where('status', 'Active')->where('users_id' , $users_id)->orderBy('expiration_date' , 'asc')->get()->first();
	}
	
	public function getFirstActive( $users_id ){
		return RegisteredCodes::where('status', 'Active')->where('users_id' , $users_id)->where('expiration_date', '>=', date('Y-m-d H:i:s') )->orderBy('expiration_date' , 'asc')->get()->first();
	}

}