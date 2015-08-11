<?php 

namespace App\Model\Dao;

use App\Model\UserAffiliationPayment;



class UserAffiliationPaymentDao  implements ICrudOperations 
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



}