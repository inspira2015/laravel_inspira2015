<?php 
namespace App\Model\Dao;

use App\Model\UserPaymentInfo;

class UserPaymentInfoDao implements ICrudOperations 
{
	
	public function getById($id) 
	{
		return UserPaymentInfo::find($id);
	}

	public function getAll() {
		return UserPaymentInfo::all();
	}

	public function delete($id) {
		if ($id) {
			$Code = UserPaymentInfo::find($id);
			$Code->delete();
		}
	}
	
	public function save() 
	{
		$id = isset($this->id) ? (int) $this->id : 0;
		$code = UserPaymentInfo::firstOrNew( array( 'id' => $id ));
		foreach($this as $key =>$value)
		{
			$code->$key = $value;
		}
		$code->save();
		return $code->id;
	}



	public function getPaymentByUserId($user_id = FALSE)
	{
		return UserPaymentInfo::where('users_id', $user_id)->get();
	}

}