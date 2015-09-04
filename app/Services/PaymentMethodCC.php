<?php 
namespace App\Services;

use Validator;

class PaymentMethodCC 
{
	private $messages = [
		'en' => [
			'cnumber.required' => 'The Card Number field is required.',
			'codigo.required' => 'The CCV field is required.',
			'expiration_date.required' => 'The expiration date field is required.',
			'expiration_date.regex' => 'The expiration date format must be YYYY/MM.',
			'birthdate.required' => 'The birthdate field is required.',
			'birthdate.regex' => 'The expiration date format must be YYYY/MM/DD.',
			'name_on_card.required' => 'The name on card field is required.',
			'zip_code.required' => 'The zip code field is required.',
			'terms.required' => 'You must accept Terms and Conditions to continue.',
			'privacy.required' => 'You must accept privacy policy to continue.'
		],
		'es' => [
			'cnumber.required' => 'El número de tarjeta es requerido.',
			'cnumber.numeric' => 'El número de tarjeta sólo puede contener números.',
			'codigo.required' => 'El código CCV es requerido.',
			'codigo.numeric' => 'El teléfono de oficina sólo puede contener números.',
			'name_on_card.required' => 'El nombre en tarjeta es requerido.',
			'name_on_card.min' => 'El nombre se requiere de una longitud mayor.',
			'expiration_date.required' => 'La fecha de Expiración es requerida.',
			'expiration_date.regex' => 'La fecha de Expiración debe de tener un formato AAAA/MM.',
			'birthdate.required' => 'La Fecha de nacimiento es requerida.',
			'birthdate.regex' => 'La fecha de nacimiento debe de tener un formato AAAA/MM/DD.',
			'address.required' => 'La dirección es requerida.',
			'city.required' => 'La ciudad es requerida.',
			'zip_code.required' => 'El código postal es requerido.',
			'terms.required' => 'Debes aceptar los términos para continuar.',
			'privacy.required' => 'Debes aceptar las políticas de privacidad para continuar.'
		]
	];

	public function validator(array $data, $lang) {
		return Validator::make($data, [
			'cnumber' => 'required|numeric',
			'ccv' => 'required|numeric',
			'expiration_date' => array('required', 'regex:/([0-9]{4})\/(0[1-9]|1[0-2])/'),
			'birthdate' => array('required', 'regex:/([0-9]{4})\/(0[1-9]|1[0-2])\/(0[1-9]|1[0-9]|2[0-9]|3[0-1])/'),
			'name_on_card' => 'required|min:4',
			'address' => 'required',
			'city' => 'required',
			'zip_code' => 'required',
			'state' => 'required',
			'terms' => 'required',
			'privacy' => 'required'

		],  $this->messages[$lang]);
	}

}
