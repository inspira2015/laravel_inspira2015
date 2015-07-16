<?php 

namespace App\Model\Entity;
use App\Model\Dao\AffiliationsDao;


class Affiliations extends AffiliationsDao
{
	public $id;
	public $name_es;
	public $name_eng;
	public $small_desc_es;
	public $small_desc_eng;
	public $tier_id;
	public $created_at;
	public $updated_at;


	public function exchangeArray(array $valid_data)
	{
		$this->id                    = (isset($valid_data['id'])) ? trim($valid_data['id']) : 0;
        $this->name_es               = (isset($valid_data['name_es'])) ? trim($valid_data['name_es']) : null;
        $this->name_eng       		 = (isset($valid_data['name_eng'])) ? trim($valid_data['name_eng']) : null;
        $this->small_desc_es         = (isset($valid_data['small_desc_es'])) ? trim($valid_data['small_desc_es']) : null;
        $this->small_desc_eng        = (isset($valid_data['small_desc_eng'])) ? trim($valid_data['small_desc_eng']) : null;
        $this->tier_id       		 = (isset($valid_data['tier_id'])) ? trim($valid_data['tier_id']) : null;        
		$this->created_at            = (isset($valid_data['created_at'])) ? trim($valid_data['created_at']) : date('Y-m-d H:i:s');
	}


}
