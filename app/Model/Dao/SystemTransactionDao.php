<?php 

namespace App\Model\Dao;

use App\Model\SystemTransaction;

class SystemTransactionDao implements ICrudOperations 
{
	
	public function getById($id) 
	{
		return SystemTransaction::find($id);
	}

	public function getAll() {
		return SystemTransaction::all();
	}

	public function delete($id) {
		if ($id) {
			$Code = SystemTransaction::find($id);
			$Code->delete();
		}
	}
	

	public function save() 
	{
		$id = isset($this->id) ? (int) $this->id : 0;
		$user = SystemTransaction::firstOrNew( array( 'id' => $id ));
		foreach($this as $key =>$value)
		{
			$user->$key = $value;
		}
		$user->save();
		return $user->id;
	}
	
	public function getLastTransaction( $users_id ){
		return SystemTransaction::orderBy('updated_at', 'desc')->where('users_id', $users_id)->first();
		
	}

	public function getCashTransaction()
	{
		return SystemTransaction::orderBy('created_at', 'desc')->where('code', 'Pending')->where('type', 'Register Cash Transaction')->get();
		
	}

}