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

		if ($id > 0) 
		{
			$new_user = UserVacLog::find($id);
			$array_data = (array)$this;
			$new_user->fill($array_data);
		} else {
			$new_user = new UserVacLog;
			foreach($this as $key =>$value)
			{
				$new_user->$key = $value;
			}

		}
			$new_user->save();
			return $new_user->id;
	}

	public function getByCode($code = FALSE)
	{
		return UserVacLog::where('code', $code)->get();
	}


}