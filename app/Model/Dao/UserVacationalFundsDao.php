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

		if ($id > 0) 
		{
			$new_user = UserVac::find($id);
			$array_data = (array)$this;
			$new_user->fill($array_data);
		} else {
			$new_user = new UserVac;
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
		return UserVac::where('code', $code)->get();
	}


}