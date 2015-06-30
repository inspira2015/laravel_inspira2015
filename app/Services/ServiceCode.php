<?php namespace App\Services;

use Validator;

class ServiceCode {

	public function validator(array $data) {
		return Validator::make($data, [
			'code' => 'required'
		]);
	}

}
