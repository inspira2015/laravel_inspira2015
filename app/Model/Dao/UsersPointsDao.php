<?php 
namespace App\Model\Dao;

use App\Model\UsersPoints;

class UsersPointsDao implements ICrudOperations 
{
	
	public function getById($id) 
	{
		return UsersPoints::find($id);
	}

	public function getAll() {
		return UsersPoints::all();
	}

	public function delete($id) {
		if ($id) {
			$Code = UsersPoints::find($id);
			$Code->delete();
		}
	}
	
	public function save() 
	{
		$id = isset($this->id) ? (int) $this->id : 0;
		$code = UsersPoints::firstOrNew( array( 'id' => $id ));
		foreach($this as $key =>$value)
		{
			$code->$key = $value;
		}
		$code->save();
		return $code->id;
	}

	public function getLatestByUserId($users_id = FALSE)
	{
		return UsersPoints::where('users_id', $users_id)->orderBy('id','desc')->first();
	}

}