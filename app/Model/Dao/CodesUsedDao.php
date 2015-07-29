<?php 

namespace App\Model\Dao;

use App\Model\CodesUsed as Code;

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

	

}