<?php namespace App\Services;

use Validator;

class UserDetails
{

	public static function validator(array $user_data) 
	{
		return Validator::make($user_data, [
			'cell' => 'numeric',
			'phone' => 'numeric',
			'office' => 'numeric',
			'city' => 'required',
			'country' => 'required',
			'state' => 'required',
		]);
	}

}
