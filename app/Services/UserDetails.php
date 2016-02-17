<?php namespace App\Services;

use Validator;

class UserDetails
{

	private $messages = [
		'en' => [],
		'es' => [
			'cell.numeric' => 'El celular sólo puede contener números.',
			'office.numeric' => 'El teléfono de oficina sólo puede contener números.',
			'phone.numeric' => 'El teléfono sólo puede contener números.',
			'state.required' => 'El campo de estado es requerido.',
			'city.required' => 'El campo de ciudad es requerido.'
		]
	];
		
	public function validator(array $user_data, $lang) 
	{
	
		return Validator::make($user_data, [
			'cell' => 'numeric',
			'phone' => 'numeric',
			'office' => 'numeric',
			'city' => 'alpha',
			'state' => 'required'
		], $this->messages[$lang]);
	}

}
