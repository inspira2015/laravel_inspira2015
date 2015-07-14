<?php 

namespace App\Model\Entity;
use App\Model\Dao\UserVacFundLogDao;


class UserVacFundLog extends UserVacFundLogDao
{
	public $id;
	public $users_id;
	public $amount;
	public $active;
	public $currency;
	public $created_at;
	public $updated_at;


	public function exchangeArray(array $valid_data)
	{
		$this->id                    = (isset($valid_data['id'])) ? trim($valid_data['id']) : 0;
        $this->users_id              = (isset($valid_data['users_id'])) ? trim($valid_data['users_id']) : null;
        $this->amount       		= (isset($valid_data['amount'])) ? trim($valid_data['amount']) : null;
        $this->active       		 = (isset($valid_data['active'])) ? trim($valid_data['active']) : null;
        $this->currency       		 = (isset($valid_data['currency'])) ? trim($valid_data['currency']) : null;		
		$this->created_at            = (isset($valid_data['created_at'])) ? trim($valid_data['created_at']) : date('Y-m-d H:i:s');
	}


}