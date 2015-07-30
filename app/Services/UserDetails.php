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
			'country.required' => 'El campo de país es requerido.',
			'city.required' => 'El campo de ciudad es requerido.'
		]
	];
		
	public static function validator(array $user_data) 
	{
	
		return Validator::make($user_data, [
			'cell' => 'numeric',
			'phone' => 'numeric',
			'office' => 'numeric',
			'city' => 'alpha',
			'country' => 'required',
			'state' => 'required'
		]);
	}

}
