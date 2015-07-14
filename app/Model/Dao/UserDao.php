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

	public function getAll() 
	{
		return User::all();
	}

	public function delete($id) 
	{
		if ($id) {
			$User = User::find($id);
			$User->delete();
		}
	}
	
	public function save() 
	{
		$id = isset($this->id) ? (int) $this->id : 0;

		if ($id > 0) {
			$new_user = User::find($id);
			$array_data = (array)$this;
			$new_user->fill($array_data);
		} else {
			$new_user = new User;
			foreach($this as $key =>$value)
			{
				$new_user->$key = $value;
			}

			//$code = User::create($this);
		}
			$new_user->save();
			return $new_user->id;

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

 	public function getPhones( $id ){
	 	return $this->getById( $id )->phones;
 	}
 	
 	public function getPhoneType( $id, $type ){
	 	return $this->getPhones( $id )->where('type', $type)->first();
 	}
 	
 	public function getAddress( $id ){
	 	return $this->getById( $id )->address;
 	}

 	public function getByFacebookId( $fbUser )
 	{
 		$user = User::where( 'facebook_id', $fbUser->id )->first();
 		if ( empty( $user ) )
 		{
 			return FALSE;
 		}
		return $user;
 	}

}