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
		$user = User::firstOrNew( array( 'id' => $id ));
		foreach($this as $key =>$value)
		{
			$user->$key = $value;
		}
		$user->save();
		return $user->id;
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

 	public function getDetails( $id )
 	{
	 	$user = new \stdClass();
	 	$phones = new \stdClass();
		
		$phones->cell = $this->getPhoneType( $id, 'cell');
		$phones->phone = $this->getPhoneType( $id, 'phone');
		$phones->office = $this->getPhoneType( $id, 'office');
		
		$user->details = $this->getById( $id );
		$user->phones = $phones;
		return $user;
 	}

 	
 	public function getPhoneType( $id, $type )
 	{
	 	return $this->getById( $id )->phones->where('type', $type)->first();
 	}
 	
 	public function getAddress( $id )
 	{
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

 	public function getUsersCode( $id )
 	{
 		return User::where( 'id', $id )->with('code_used')->first();

 	}

}