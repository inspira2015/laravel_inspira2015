<?php 

namespace App\Model\Entity;
use App\Model\Dao\ExchangeRateDao;


class ExchangeRateEntity extends ExchangeRateDao
{
	public $id;
	public $exchange_type;
	public $exchange_date;
	public $exchange_rate;
	public $created_at;
	public $updated_at;


	public function exchangeArray(array $valid_data)
	{
		$this->id                    = (isset($valid_data['id'])) ? trim($valid_data['id']) : 0;
        $this->exchange_type         = (isset($valid_data['exchange_type'])) ? trim($valid_data['exchange_type']) : null;
        $this->exchange_date       	 = (isset($valid_data['exchange_date'])) ? trim($valid_data['exchange_date']) : null;
        $this->exchange_rate         = (isset($valid_data['exchange_rate'])) ? trim($valid_data['exchange_rate']) : null;
		$this->created_at            = (isset($valid_data['created_at'])) ? trim($valid_data['created_at']) : date('Y-m-d H:i:s');
	}


}
