<?php 

namespace App\Model\Dao;
use DB;
use App\Model\UserAffiliationPayment;



class UserAffiliationPaymentDao  implements ICrudOperations 
{
	public function getById($id) 
	{
		return UserAffiliationPayment::find($id);
	}

	public function getAll() 
	{
		return UserAffiliationPayment::all();
	}

	public function delete($id) 
	{
		if ($id) {
			$User = UserAffiliationPayment::find($id);
			$User->delete();
		}
	}
	
	public function save() 
	{
		$id = isset($this->id) ? (int) $this->id : 0;
		$user = UserAffiliationPayment::firstOrNew( array( 'id' => $id ));
		foreach($this as $key =>$value)
		{
			$user->$key = $value;
		}
		$user->save();
		return $user->id;
	}

	public function checkPaymentByUserMonth($user_id, $month)
	{
		$tempMont = array($month);
		$userAff = UserAffiliationPayment::where('users_id',$user_id)->whereRaw('MONTH(charge_at) = ?',$tempMont)->get();
		if(empty($userAff[0]))
		{
			return FALSE;
		}
		return TRUE;
	}

}