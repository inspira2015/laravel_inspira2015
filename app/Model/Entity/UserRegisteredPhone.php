<?php 

namespace App\Model\Entity;


class UserRegisteredPhone
{
	public $id;
	public $users_id;
	public $type;
	public $number;
	public $created_at;
	public $updated_at;


	public function exchangeArray(array $valid_data)
	{
		$this->id                    = (isset($valid_data['id'])) ? trim($valid_data['id']) : 0;
        $this->users_id            	 = (isset($valid_data['users_id'])) ? trim($valid_data['users_id']) : null;
        $this->type                  = (isset($valid_data['type'])) ? trim($valid_data['type']) : null;
        $this->number              	 = $this->encryptPassword($valid_data);
		$this->created_at            = (isset($valid_data['created_at'])) ? trim($valid_data['created_at']) : date('Y-m-d H:i:s');
	}


	private function phoneFilter(array $valid_data)
	{
		$temp_password = (isset($valid_data['password'])) ? trim($valid_data['password']) : null;
		return bcrypt($temp_password);
	}

	private function getConfirmationCode()
	{
		$hash = md5( rand(0,1000) ); // Generate random 32 character hash and assign it to a local variable.
		return $hash;
	}

}
