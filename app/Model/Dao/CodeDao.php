<?php 

namespace App\Model\Dao;

use App\Model\Code;

class CodeDao implements ICrudOperations {
	
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
	
	public function save(array $data) {
		$id = isset($data['id']) ? (int) $data['id'] : 0;
		
		if ($id > 0) {
			$code = Code::find($id);
			$code->fill($data);
		} else {
			$code = Code::create($data);
		}
			$code->save();
	}

	public function getByCode($code = FALSE)
	{
		return Code::where('code', $code);
	}


}