<?php 

namespace App\Model\Entity;
use App\Model\Dao\ReservationsDao;


class UserReservationEntity extends ReservationsDao
{
	public $id;
	public $leisure_id;
	public $extra;
	public $confirmation_code;

	public function exchangeArray(array $valid_data)
	{
		$this->id                   = (isset($valid_data['id'])) ? trim($valid_data['id']) : 0;
        $this->leisure_id           = (isset($valid_data['member_id'])) ? trim($valid_data['member_id']) : null;
        $this->extra 				= (isset($valid_data['email_content'])) ? trim($valid_data['email_content']) : null;
        $this->confirmation_code	= (isset($valid_data['confirmation_code'])) ? trim($valid_data['confirmation_code']) : null;
	}


}
