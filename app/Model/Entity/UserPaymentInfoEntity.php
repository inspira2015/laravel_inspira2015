<?php 

namespace App\Model\Entity;
use App\Model\Dao\UserPaymentInfoDao;
use carbon;


class UserPaymentInfoEntity extends UserPaymentInfoDao
{
	public $id;
	public $users_id;
	public $transaction_id;
	public $token;
	public $ccv;
	public $name_on_card;
	public $birthdate;
	public $payment_method;
	public $address;
	public $address2;
	public $city;
	public $state;
	public $zip_code;
	public $country;
	public $created_at;
	public $updated_at;


	public function exchangeArray(array $valid_data)
	{
		$this->id                   = (isset($valid_data['id'])) ? trim($valid_data['id']) : 0;
        $this->users_id             = (isset($valid_data['users_id'])) ? trim($valid_data['users_id']) : null;
        $this->transaction_id       = (isset($valid_data['transaction_id'])) ? trim($valid_data['transaction_id']) : null;
        $this->token       			= (isset($valid_data['token'])) ? trim($valid_data['token']) : null;
        $this->ccv       			= (isset($valid_data['ccv'])) ? trim($valid_data['ccv']) : null;        
        $this->name_on_card       	= (isset($valid_data['name_on_card'])) ? trim($valid_data['name_on_card']) : null;
 		$this->birthdate       		= $this->checkDate($valid_data);
 		$this->payment_method       = (isset($valid_data['payment_method'])) ? trim($valid_data['payment_method']) : null;
        $this->address       		= (isset($valid_data['address'])) ? trim($valid_data['address']) : null;
        $this->address2       		= (isset($valid_data['address2'])) ? trim($valid_data['address2']) : null;
		$this->city       			= (isset($valid_data['city'])) ? trim($valid_data['city']) : null;
        $this->state       			= (isset($valid_data['state'])) ? trim($valid_data['state']) : null;
 		$this->zip_code       		= (isset($valid_data['zip_code'])) ? trim($valid_data['zip_code']) : null;
        $this->country       		= (isset($valid_data['country'])) ? trim($valid_data['country']) : null;
		$this->created_at           = (isset($valid_data['created_at'])) ? trim($valid_data['created_at']) : date('Y-m-d H:i:s');
	}


	public function checkDate(array $valid_data)
	{
		$postBirthDate = (isset($valid_data['birthdate'])) ? trim($valid_data['birthdate']) : null;
		$birthdate = Carbon::createFromFormat('Y/m/d', $postBirthDate);
		return $birthdate->toDateString();
	}


}
