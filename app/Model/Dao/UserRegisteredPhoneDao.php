<?php
namespace App\Model\Dao;

use App\Model\UserRegisteredPhones;
use App\Model\Entity\UserRegisteredPhoneEntity;


class UserRegisteredPhoneDao extends UserRegisteredPhoneEntity implements ICrudOperations 
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
		$temp_table = UserRegisteredPhones::firstOrNew( array('users_id' => $this->users_id, 'type' => $this->type) );
		$temp_table->number = $this->number;
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

 	public function findByUserType( $users_id, $type )
 	{
	 	$phone = UserRegisteredPhones::where('users_id', $users_id )->where('type', $type )->first();
	 	if( empty($phone) )
	 		return FALSE;
	 	return $phone;
	 	
 	}

}