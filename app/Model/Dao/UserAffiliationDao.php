<?php 

namespace App\Model\Dao;

use App\Model\UserAffiliations as UserAff;

class UserAffiliationDao implements ICrudOperations 
{
	
	public function getById($id) 
	{
		return UserAff::find($id);
	}

	public function getAll() 
	{
		return UserAff::all();
	}

	public function delete($id) 
	{
		if ($id) 
		{
			$Code = UserAff::find($id);
			$Code->delete();
		}
	}
	
	public function save() 
	{
		$id = isset($this->id) ? (int) $this->id : 0;

		if ($id > 0) 
		{
			$new_user = UserAff::find($id);
			$array_data = (array)$this;
			$new_user->fill($array_data);
		} else {
			$new_user = new UserAff;
			foreach($this as $key =>$value)
			{
				$new_user->$key = $value;
			}

		}
			$new_user->save();
			return $new_user->id;
	}

	public function getByUsersId($users_id = FALSE)
	{
		$queryAff = UserAff::where('users_id', $users_id)->get();
		if ( empty( $queryAff->all() ) )
		{
			return FALSE;
		}
		return $queryVac;
	}


}