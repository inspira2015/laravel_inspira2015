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

		$userAff = UserAff::firstOrNew( array( 'id' => $id ));
		foreach($this as $key =>$value)
		{
			$userAff->$key = $value;
		}
		$userAff->save();
		return $userAff->id;
	}

	public function getByUsersId($users_id = FALSE)
	{
		$queryAff = UserAff::where('users_id', $users_id)->get();
		if ( empty( $queryAff->all() ) )
		{
			return FALSE;
		}
		return $queryAff;
	}


	public function getAffiliationByUsersId($users_id = FALSE)
	{
		$queryAff = UserAff::has('affiliation')->where('users_id', $users_id)->get();
		if ( empty( $queryAff->all() ) )
		{
			return FALSE;
		}
		return $queryAff;
	}
}