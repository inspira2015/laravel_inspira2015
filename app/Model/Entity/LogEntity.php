<?php 
namespace App\Model\Entity;
use App\Model\Dao\LogDao;


class LogEntity extends LogDao
{
	public $id;
	public $users_id;
	public $module;
	public $action;
	public $method;
	public $description;


	public function exchangeArray(array $valid_data)
	{
		$this->id                    = (isset($valid_data['id'])) ? trim($valid_data['id']) : 0;
        $this->users_id              = (isset($valid_data['users_id'])) ? trim($valid_data['users_id']) : null;
        $this->module              = (isset($valid_data['module'])) ? trim($valid_data['module']) : null;
        $this->action              = (isset($valid_data['action'])) ? trim($valid_data['action']) : null;
        $this->method              = (isset($valid_data['method'])) ? trim($valid_data['method']) : null;
		$this->description 		   = (isset($valid_data['description'])) ? trim($valid_data['description']) : null;
	}


}
