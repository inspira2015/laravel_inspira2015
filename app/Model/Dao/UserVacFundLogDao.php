<?php 

namespace App\Model\Dao;

use App\Model\VacationFundLog as UserVacLog;

class UserVacFundLogDao implements ICrudOperations 
{
	
	public function getById($id) 
	{
		return UserVacLog::find($id);
	}

	public function getAll() 
	{
		return UserVacLog::all();
	}

	public function delete($id) 
	{
		if ($id) 
		{
			$Code = UserVacLog::find($id);
			$Code->delete();
		}
	}
	
	public function save() 
	{
		$id = isset($this->id) ? (int) $this->id : 0;
		$vacLog = UserVacLog::firstOrNew( array( 'id' => $id ));
		foreach($this as $key =>$value)
		{
			$vacLog->$key = $value;
		}
		$vacLog->save();
		return $vacLog->id;

	}

	public function getByUsersId($users_id = FALSE)
	{
		$queryVac = UserVacLog::where('users_id', $users_id)->get();
		if ( empty( $queryVac->all() ) )
		{
			return FALSE;
		}
		return $queryVac;
	}


	public function getCurrentUserVacFundLogByUserId($users_id = FALSE)
	{
		$query = UserVacLog::where('users_id', $users_id)->where('active',1)->orderBy('id','desc')->first();
		if ( empty( $query ) )
		{
			return FALSE;
		}
		return $query;

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

}