<?php 
namespace App\Services;

use Validator;

class PaymentMethodCC 
{
	private $messages = [
		'en' => [],
		'es' => [
			'cnumber.required' => 'El número de tarjeta es requerido.',
			'cnumber.numeric' => 'El número de tarjeta sólo puede contener números.',
			'codigo.required' => 'El código CCV es requerido.',
			'codigo.numeric' => 'El teléfono de oficina sólo puede contener números.',
			'name_on_card.required' => 'El nombre en tarjeta es requerido.',
			'name_on_card.min' => 'El nombre se requiere de una longitud mayor.',
			'expiration_date.required' => 'La fecha de Expiración es requerida.',
			'expiration_date.regex' => 'La fecha de Expiración debe de tener un formato AAAA/MM.',
			'address.required' => 'La dirección es requerida.',
			'city.required' => 'La ciudad es requerida.',
			'zip_code.required' => 'El código postal es requerido.'
		]
	];

	public function validator(array $data, $lang) {
		return Validator::make($data, [
			'cnumber' => 'required|numeric',
			'codigo' => 'required|numeric',
			'expiration_date' => array('required', 'regex:/([0-9]{4})\/(0[1-9]|1[0-2])/'),
			'name_on_card' => 'required|min:4',
			'address' => 'required',
			'city' => 'required',
			'zip_code' => 'required',

		],  $this->messages[$lang]);
	}

}
