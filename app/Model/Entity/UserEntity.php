<?php 

namespace App\Model\Entity;


class UserEntity 
{
	public $id;
	public $leisure_id;
	public $email;
	public $password;
	public $active;
	public $remember_token;
	public $name;
	public $last_name;
	public $confirmed;
	public $language;
	public $created_at;
	public $updated_at;
	public $confirmation_code;
	public $country;
	public $state;



	public function exchangeArray(array $valid_data)
	{
		$this->id                    = (isset($valid_data['id'])) ? trim($valid_data['id']) : 0;
        $this->leisure_id            = (isset($valid_data['leisure_id'])) ? trim($valid_data['leisure_id']) : null;
        $this->email                 = (isset($valid_data['email'])) ? trim($valid_data['email']) : null;
        $this->password              = $this->encryptPassword($valid_data);
        $this->active                = (isset($valid_data['active'])) ? trim($valid_data['active']) : 1;
		$this->remember_token        = (isset($valid_data['remember_token'])) ? trim($valid_data['remember_token']) : null;
        $this->name              	 = (isset($valid_data['name'])) ? trim($valid_data['name']) : null;
        $this->last_name             = (isset($valid_data['last_name'])) ? trim($valid_data['last_name']) : null;
        $this->confirmed             = (isset($valid_data['confirmed'])) ? trim($valid_data['confirmed']) : 0;
        $this->language              = (isset($valid_data['language'])) ? trim($valid_data['language']) : 'es';
		$this->created_at            = (isset($valid_data['created_at'])) ? trim($valid_data['created_at']) : date('Y-m-d H:i:s');
        $this->confirmation_code     = $this->getConfirmationCode();
	    $this->country             	 = (isset($valid_data['country'])) ? trim($valid_data['country']) : null;
        $this->state             	 = (isset($valid_data['state'])) ? trim($valid_data['state']) : null;

	}


	private function encryptPassword(array $valid_data)
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
