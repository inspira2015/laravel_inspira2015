<?php 
namespace App\Services;

use Validator;

class PaymentCC 
{
	private $messages = [
		'en' => [
			'cnumber.required' => 'The Card Number field is required.',
			'ccv.required' => 'The CCV field is required.',
			'expiration_date.required' => 'The expiration date field is required.',
			'expiration_date.regex' => 'The expiration date format must be MM/YYYY.',
			'birthdate.required' => 'The birthdate field is required.',
			'birthdate.regex' => 'The birthdate format must be YYYY/MM/DD.',
			'name_on_card.required' => 'The name on card field is required.',
			'amount.required' => 'The amount field is required.'
		],
		'es' => [
			'cnumber.required' => 'El número de tarjeta es requerido.',
			'cnumber.numeric' => 'El número de tarjeta sólo puede contener números.',
			'ccv.required' => 'El código CCV es requerido.',
			'ccv.numeric' => 'El teléfono de oficina sólo puede contener números.',
			'name_on_card.required' => 'El nombre en tarjeta es requerido.',
			'name_on_card.min' => 'El nombre se requiere de una longitud mayor.',
			'expiration_date.required' => 'La fecha de Expiración es requerida.',
			'expiration_date.regex' => 'La fecha de Expiración debe de tener un formato MM/AAAA.',
			'birthdate.required' => 'La Fecha de nacimiento es requerida.',
			'birthdate.regex' => 'La fecha de nacimiento debe de tener un formato AAAA/MM/DD.',
			'address.required' => 'La dirección es requerida.',
			'amount.required' => 'La cantidad es requerida.'
		]
	];

	public function validator(array $data, $lang) {
		return Validator::make($data, [
			'cnumber' => 'required|numeric',
			'ccv' => 'required|numeric',
			'expiration_date' => array('required', 'regex:/(0[1-9]|1[0-2])\/([0-9]{4})/'),
			'birthdate' => array('required', 'regex:/([0-9]{4})\/(0[1-9]|1[0-2])\/(0[1-9]|1[0-9]|2[0-9]|3[0-1])/'),
			'name_on_card' => 'required|min:4',
			'amount' => 'required'

		],  $this->messages[$lang]);
	}

}
