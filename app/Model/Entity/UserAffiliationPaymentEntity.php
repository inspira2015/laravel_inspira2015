<?php 

namespace App\Model\Entity;
use App\Model\Dao\UserAffiliationPaymentDao;


class UserAffiliationPaymentEntity extends UserAffiliationPaymentDao
{
	public $id;
	public $users_id;
	public $charge_at;
	public $transaction_id;
	public $affiliations_id;
	public $amount;
	public $currency;
	public $payu_transaction_id;
	public $created_at;
	public $updated_at;


	public function exchangeArray(array $valid_data)
	{
		$this->id                    = (isset($valid_data['id'])) ? trim($valid_data['id']) : 0;
        $this->users_id              = (isset($valid_data['users_id'])) ? trim($valid_data['users_id']) : null;
        $this->charge_at       		 = (isset($valid_data['charge_at'])) ? trim($valid_data['charge_at']) : null;
        $this->transaction_id        = (isset($valid_data['transaction_id'])) ? trim($valid_data['transaction_id']) : null;
        $this->affiliations_id       = (isset($valid_data['affiliations_id'])) ? trim($valid_data['affiliations_id']) : null;
        $this->amount       		 = (isset($valid_data['amount'])) ? trim($valid_data['amount']) : null;
        $this->currency       		 = (isset($valid_data['currency'])) ? trim($valid_data['currency']) : null;
        $this->payu_transaction_id   = (isset($valid_data['payu_transaction_id'])) ? trim($valid_data['payu_transaction_id']) : null;
		$this->created_at            = (isset($valid_data['created_at'])) ? trim($valid_data['created_at']) : date('Y-m-d H:i:s');
	}


}
