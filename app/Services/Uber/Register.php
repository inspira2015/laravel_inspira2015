<?php namespace App\Services\Uber;

use Validator;

class Register
{
	private $messages = array(
		'en' => [],
		'es' => [
		//	'name.alpha' => 'El nombre sólo puede contener letras.',
			'name.required' => 'El nombre es requerido.',
			'last_name.alpha' => 'El apellido sólo puede contener letras.',
			'last_name.required' => 'El apellido es requerido.',
			'email.email' => 'El correo electrónico tiene que ser una dirección válida.',
			'email.unique' => 'La dirección de correo electrónico ya ha sido tomada.',
			'email.required' => 'El correo electrónico es requerido.',
			'password.min' => 'La contraseña debe tener como mínimo 6 caracteres.',
			'password.required' => 'La contraseña es requerida.',
			'password.confirmed' => 'Las contraseñas no coinciden.'
		]
	);

	public function validator(array $user_data, $lang) 
	{
		return Validator::make($user_data, [
			'name' => 'required',
			'last_name' => 'required|alpha',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6|confirmed',
			'password_confirmation' => 'required_with:password',
		], $this->messages[$lang]);
	}


}
