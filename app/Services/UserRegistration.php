<?php namespace App\Services;

use Validator;

class UserRegistration 
{
	private $messages = array(
		'en' => [],
		'es' => [
			'name.alpha' => 'El nombre sólo puede contener letras.',
			'last_name.alpha' => 'El apellido sólo puede contener letras.',
			'email.email' => 'El correo electrónico tiene que ser una dirección válida.',
			'email.unique' => 'La dirección de correo electrónico ya ha sido tomada.',
			'state.alpha' => 'El estado sólo puede contener letras.',
			'password.min' => 'La contraseña debe tener como mínimo 6 caracteres.',
			'cellphone_number.min' => 'El celular debe tener como mínimo 10 digitos.'
		]
	);

	public function validator(array $user_data, $lang) 
	{
		return Validator::make($user_data, [
			'name' => 'required|alpha',
			'last_name' => 'required|alpha',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6',
			'cellphone_number' => 'required|numeric|min:10',
			'state' => 'required|alpha',
		], $this->messages[$lang]);
	}


}
