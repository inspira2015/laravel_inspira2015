<?php 
namespace App\Services;

use Validator;

class PaymentMethodCC 
{

	public static function validator(array $data) {
		return Validator::make($data, [
			'cnumber' => 'required|numeric',
			'codigo' => 'required|numeric',
			'exp_month' => 'required|numeric|min:2',
			'exp_year' => 'required|numeric|min:4',
			'name_on_card' => 'required|min:4',
			'address' => 'required',
			'city' => 'required',
			'zip_code' => 'required',

		]);
	}

}
