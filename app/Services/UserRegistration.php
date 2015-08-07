<?php namespace App\Services;

use Validator;

class UserRegistration 
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
			'state.alpha' => 'El estado sólo puede contener letras.',
			'state.required' => 'El estado es requerido.',
			'password.min' => 'La contraseña debe tener como mínimo 6 caracteres.',
			'password.required' => 'La contraseña es requerida.',
			'password.confirmed' => 'Las contraseñas no coinciden.',
 			'password_confirmation.required' => 'La confirmación de contraseña es requerida.',
			'cellphone_number.min' => 'El número de celular debe tener como mínimo 10 dígitos.',
			'cellphone_number.required' => 'El número de celular es requerido.'
		]
	);

	public function validator(array $user_data, $lang) 
	{
		return Validator::make($user_data, [
			'name' => 'required',
			'last_name' => 'required|alpha',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6|confirmed',
			'password_confirmation' => 'required',
			'cellphone_number' => 'required|numeric|min:10',
			'state' => 'required|alpha',
		], $this->messages[$lang]);
	}


}
