<?php 
namespace App\Services\Api;

use Validator;

class Reservation
{
	private $messages;
	
	public function validator(array $data)
	{
		return Validator::make($data, [
			'apiKey' => 'required',
			'member_id' => 'required|exists:users,leisure_id',
			'confirmation_code' => 'required|unique:api_users_reservations',
			'email_body' => 'required',
		]);
	} 
}
