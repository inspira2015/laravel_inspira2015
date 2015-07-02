<?php namespace App\Services;

use Validator;

class ServiceCode {

	public static function validator(array $data) {
		return Validator::make($data, [
			'code' => 'required'
		]);
	}

}
