<?php 
namespace App\Model\Entity;
use App\Model\Dao\SystemTransactionDao;


class SystemTransactionEntity extends SystemTransactionDao
{
	public $id;
	public $users_id;
	public $code;
	public $type;
	public $description;
	public $json_data;
	public $amount;
	public $currency;
	public $payu_transaction_id;
	public $created_at;
	public $updated_at;


	public function exchangeArray(array $valid_data)
	{
		$this->id                    = (isset($valid_data['id'])) ? trim($valid_data['id']) : 0;
        $this->users_id              = (isset($valid_data['users_id'])) ? trim($valid_data['users_id']) : null;
        $this->code       			 = (isset($valid_data['code'])) ? trim($valid_data['code']) : null;
        $this->type       		 	 = (isset($valid_data['type'])) ? trim($valid_data['type']) : null;
        $this->description           = (isset($valid_data['description'])) ? trim($valid_data['description']) : null;
        $this->json_data       		 = (isset($valid_data['json_data'])) ? trim($valid_data['json_data']) : null;
        $this->amount       		 = (isset($valid_data['amount'])) ? trim($valid_data['amount']) : null;
        $this->currency       		 = (isset($valid_data['currency'])) ? trim($valid_data['currency']) : null;
        $this->payu_transaction_id   = (isset($valid_data['payu_transaction_id'])) ? trim($valid_data['payu_transaction_id']) : null;
		$this->created_at            = (isset($valid_data['created_at'])) ? trim($valid_data['created_at']) : date('Y-m-d H:i:s');
	}


}
