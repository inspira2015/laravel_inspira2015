<?php namespace App\Services;

use Validator;

class VacationFund
{
	private $messages = array(
		'en' => [],
		'es' => [
			'amount.numeric' => 'El monto debe ser numérico.',
			'fondo.required' => 'El campo de fondo es requerido.',
			'fondo.numeric' => 'El tipo de fondo debe ser numérico.'
		]
	);

	public function validator(array $user_data, $lang) 
	{
		return Validator::make($user_data, [
			'amount' => 'numeric',
			'fondo' => 'required|numeric'
		], $this->messages[$lang]);
	}


}
