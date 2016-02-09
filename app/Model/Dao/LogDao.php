<?php 

namespace App\Model\Dao;

use App\Model\SystemLog;

class LogDao
{
	
	public function getById($id) 
	{
		return SystemLog::find($id);
	}

	public function getAll() {
		return SystemLog::all();
	}

	public function save() 
	{
		$id = isset($this->id) ? (int) $this->id : 0;
		$log = SystemLog::firstOrNew( array( 'id' => $id ));
		foreach($this as $key =>$value)
		{
			$log ->$key = $value;
		}
		$log->save();
		return $log->id;
	}
	

}