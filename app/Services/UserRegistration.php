<?php namespace App\Services;

use Validator;

class UserRegistration 
{

	public function validator(array $user_data) 
	{
		return Validator::make($user_data, [
			'name' => 'required',
			'last_name' => 'required|alpha',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6',
			'cellphone_number' => 'required',
			'state' => 'required',
		]);
	}

}
