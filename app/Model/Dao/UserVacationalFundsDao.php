<?php 

namespace App\Model\Dao;

use App\Model\UserVacationalFunds as UserVac;

class UserVacationalFundsDao implements ICrudOperations 
{
	
	public function getById($id) 
	{
		return UserVac::find($id);
	}

	public function getAll() 
	{
		return UserVac::all();
	}

	public function delete($id) 
	{
		if ($id) 
		{
			$Code = UserVac::find($id);
			$Code->delete();
		}
	}
	
	public function save() 
	{

		$id = isset($this->id) ? (int) $this->id : 0;
		$vacLog = UserVac::firstOrNew( array( 'id' => $id ));
		foreach($this as $key =>$value)
		{
			$vacLog->$key = $value;
		}
		$vacLog->save();
		return $vacLog->id;

	}

	public function getByCode($code = FALSE)
	{
		return UserVac::where('code', $code)->get();
	}

	public function getLatestByUserId($users_id = FALSE)
	{
		return UserVac::where('users_id', $users_id)->orderBy('id','desc')->first();
	}

}