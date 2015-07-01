<?php 

namespace App\Model\Dao;

use App\Model\User;
use App\Model\Entity\UserEntity;


class UserDao extends UserEntity implements ICrudOperations 
{

	public function getById($id) 
	{
		return User::find($id);
	}

	public function getAll() {
		return User::all();
	}

	public function delete($id) {
		if ($id) {
			$User = User::find($id);
			$User->delete();
		}
	}
	
	public function save(array $data) {
		$id = isset($this->id) ? (int) $this->id : 0;

		if ($id > 0) {
			$new_user = User::find($id);
			$new_user->fill($this);
		} else {
			$new_user = new User;
			foreach($this as $key =>$value)
			{
				$new_user->$key = $value;
			}

			//$code = User::create($this);
		}
			$new_user->save();
	}

	public function load($id)
	{

		$this->populate($this->getById($id));
	}

	private function populate($row)
 	{
 		foreach($row->toArray() as $key => $value)
 		{
 			$this->$key = $value;
 		}
 	}


	public function getByCode($code = FALSE)
	{
		return User::where('code', $code);
	}


}