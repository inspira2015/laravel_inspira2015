<?php 

namespace App\Model\Dao;

use App\Model\CodesUsed as Code;
use App\Model\Codes as Codes;

class CodesUsedDao implements ICrudOperations 
{
	
	public function getById($id) 
	{
		return Code::find($id);
	}

	public function getAll() {
		return Code::all();
	}

	public function delete($id) {
		if ($id) {
			$Code = Code::find($id);
			$Code->delete();
		}
	}
	
	public function save() 
	{
		$id = isset($this->id) ? (int) $this->id : 0;
		$code = Code::firstOrNew( array( 'id' => $id ));
		foreach($this as $key =>$value)
		{
			$code->$key = $value;
		}
		$code->save();
		return $code->id;
	}

	public function getCodesUsedByUserId($users_id = FALSE)
	{
		$codesUsed = Code::has('code')->where('users_id', $users_id)->get();
		if ( empty( $codesUsed->all() ) )
		{
			return FALSE;
		}
		return $codesUsed[0];
	}
	
}