<?php namespace App\Services;

use App\Model\Code;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Code {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'code' => 'required|unique:codes'
		]);
	}

}
