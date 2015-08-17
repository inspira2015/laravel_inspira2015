<?php 

namespace App\Model\Entity;
use App\Model\Dao\UserVacationalFundsDao;


class UserVacationalFunds extends UserVacationalFundsDao
{
	public $id;
	public $users_id;
	public $transaction_id;
	public $description;
	public $added_amount;
	public $substracted_amount;
	public $currency;
	public $balance;
	public $created_at;
	public $updated_at;


	public function exchangeArray(array $valid_data)
	{
		$this->id                    	= (isset($valid_data['id'])) ? trim($valid_data['id']) : 0;
        $this->users_id              	= (isset($valid_data['users_id'])) ? trim($valid_data['users_id']) : null;
        $this->transaction_id       	= (isset($valid_data['transaction_id'])) ? trim($valid_data['transaction_id']) : null;
        $this->description       		= (isset($valid_data['description'])) ? trim($valid_data['description']) : null;
		$this->added_amount             = (isset($valid_data['added_amount'])) ? trim($valid_data['added_amount']) : null;
        $this->substracted_amount       = (isset($valid_data['substracted_amount'])) ? trim($valid_data['substracted_amount']) : null;
        $this->currency       		 	= (isset($valid_data['currency'])) ? trim($valid_data['currency']) : null;
        $this->balance       		 	= (isset($valid_data['balance'])) ? trim($valid_data['balance']) : null;
		$this->created_at            = (isset($valid_data['created_at'])) ? trim($valid_data['created_at']) : date('Y-m-d H:i:s');
	}


}
