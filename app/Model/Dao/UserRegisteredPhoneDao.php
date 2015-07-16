<?php
namespace App\Model\Dao;

use App\Model\UserRegisteredPhones;
use App\Model\Entity\UserRegisteredPhone;


class UserRegisteredPhoneDao implements ICrudOperations 
{


	public function getById($id) 
	{
		return UserRegisteredPhones::find($id);
	}

	public function getAll() {
		return UserRegisteredPhones::all();
	}

	public function delete($id) {
		if ($id) {
			$temp_table = UserRegisteredPhones::find($id);
			$temp_table->delete();
		}
	}
	
	public function save() {
		$id = isset($this->id) ? (int) $this->id : 0;

		if ($id > 0) {
			$temp_table = UserRegisteredPhones::find($id);
			$temp_table->fill($this);
		} else {
			$temp_table = new UserRegisteredPhones;
			foreach($this as $key =>$value)
			{
				$temp_table->$key = $value;
			}

			//$code = User::create($this);
		}
			$temp_table->save();
			return $temp_table->id;

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

 	public function getByUserType( $users_id, $type )
 	{
	 	$phone = UserRegisteredPhones::where('users_id', $users_id )->where('type', $type )->get();
	 	$this->populate( $phone );
 	}

}