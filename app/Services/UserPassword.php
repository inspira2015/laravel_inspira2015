<?php namespace App\Services;
use Validator;

class UserPassword {
	
	private $messages = [
		'en' => [],
		'es' => [
			'password.different' => 'La confirmación de la contraseña no coincide.', 
			'password_confirmation.required_with' => 'La Confirmación de contraseña se 
									requiere cuando la contraseña está presente.',
			'password.min' => 'La contraseña debe tener como mínimo 6 caracteres.',
			'password.required' => 'La contraseña es requerida.',
			'password.confirmed' => 'Las contraseñas no coinciden.',
 			'password_confirmation.required' => 'La confirmación de contraseña es requerida.',
		]
	];
	
	public function validator(array $data, $lang) {
		return Validator::make($data, [
			'current_password' => 'required|min:5',
			'password' => 'required|min:8|confirmed|different:current_password',
			'password_confirmation' => 'required_with:password|min:8'
		], $this->messages[$lang]);
	}

}
