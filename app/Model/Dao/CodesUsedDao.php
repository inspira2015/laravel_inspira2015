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
	
	public function save() {
		$id = isset($data['id']) ? (int) $data['id'] : 0;
		
		if ($id > 0) {
			$code = Code::find($id);
			$array_data = (array)$this;
			$code->fill($array_data);
		} else {
			$code = new Code;
			foreach($this as $key =>$value)
			{
				$code->$key = $value;
			}
		}
			$code->save();
			return $code->id;
	}

	

}