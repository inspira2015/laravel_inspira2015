<?php 

namespace App\Model\Dao;

use App\Model\Affiliations;

class AffiliationsDao implements ICrudOperations 
{
	
	public function getById($id) 
	{
		return Affiliations::find($id);
	}

	public function getAll() {
		return Affiliations::all();
	}

	public function delete($id) {
		if ($id) {
			$Code = Affiliations::find($id);
			$Code->delete();
		}
	}
	
	public function save() {
		$id = isset($data['id']) ? (int) $data['id'] : 0;
		
		if ($id > 0) {
			$affiliation = Affiliations::find($id);
			$array_data = (array)$this;
			$affiliation->fill($array_data);
		} else {
			$affiliation = new Affiliations;
			foreach($this as $key =>$value)
			{
				$affiliation->$key = $value;
			}

		}
			$affiliation->save();
			return $affiliation->id;
	}


}