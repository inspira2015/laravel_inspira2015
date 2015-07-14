<?php 

namespace App\Model\Entity;
use App\Model\Dao\CodesUsedDao;


class CodesUsedEntity extends CodesUsedDao
{
	public $id;
	public $codes_id;
	public $users_id;
	public $created_at;
	public $updated_at;


	public function exchangeArray(array $valid_data)
	{
		$this->id                    = (isset($valid_data['id'])) ? trim($valid_data['id']) : 0;
        $this->codes_id            	 = (isset($valid_data['codes_id'])) ? trim($valid_data['codes_id']) : null;
        $this->users_id              = (isset($valid_data['users_id'])) ? trim($valid_data['users_id']) : null;

	}


}
