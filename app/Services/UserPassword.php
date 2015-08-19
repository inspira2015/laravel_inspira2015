<?php namespace App\Services;
use Validator;

class UserPassword {
	
	
	
	public function validator(array $data) {
		return Validator::make($data, [
			'current_password' => 'required|min:5',
			'password' => 'required|min:8|confirmed|different:current_password',
			'password_confirmation' => 'required_with:password|min:8'
		]);
	}

}
