<?php 

namespace App\Model\Entity;

use App\Model\Dao\UserRegisteredPhoneDao;

class UserRegisteredPhoneEntity
{
	public $id;
	public $users_id;
	public $type;
	public $number;
	public $created_at;
	public $updated_at;


	public function exchangeArray(array $data)
	{
		$valid_data =$this->checkNumberType($data);
		$this->id                    = (isset($valid_data['id'])) ? trim($valid_data['id']) : 0;
        $this->users_id            	 = (isset($valid_data['users_id'])) ? trim($valid_data['users_id']) : null;
        $this->type                  = (isset($valid_data['type'])) ? trim($valid_data['type']) : null;
        $this->number              	 = (isset($valid_data['number'])) ? trim($valid_data['number']) : null;
		$this->created_at            = (isset($valid_data['created_at'])) ? trim($valid_data['created_at']) : date('Y-m-d H:i:s');
	}


	private function checkNumberType(array $valid_data)
	{
		if(array_key_exists('type',$valid_data)==TRUE && array_key_exists('number',$valid_data))
		{
			return $valid_data;
		}

		$var_array = array();
		foreach ($valid_data AS $key => $value) 
		{
			$temp = stristr($key, 'number');
			if ( $temp!== FALSE) 
			{
				$temp_key = $key;
				list($type,$temp) = explode('_',$key);
			} 
		}
		$valid_data['type'] = $type;
		$valid_data['number'] = $valid_data[$temp_key];
		return $valid_data;
	}


}
