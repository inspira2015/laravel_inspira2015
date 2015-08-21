<?php 
namespace App\Services;

use Validator;

class Payment
{
	private $messages;

	public function validatorMXN(array $data, $lang) {
		$this->messages = [
			'en' => [
			],
			'es' => [
				'amount.required' => 'La cantidad es requerida.',
				'amount.numeric' => 'La cantidad sólo puede contener números.',
				'amount.min' => 'La cantidad mínima es de 40 MXN.'
			]
		];
		
		return Validator::make($data, [
			'amount' => 'numeric|required|min:40',
			'currency' => 'in:MXN'

		],  $this->messages[$lang]);
	}

	
	public function validatorUSD(array $data, $lang) {
		$this->messages = [
			'en' => [
			],
			'es' => [
				'amount.required' => 'La cantidad es requerida.',
				'amount.numeric' => 'La cantidad sólo puede contener números.',
				'amount.min' => 'La cantidad mínima es de 3 USD'
			]
		];
		
		return Validator::make($data, [
			'amount' => 'numeric|required|min:3',
			'currency' => 'in:USD'

		],  $this->messages[$lang]);
	}
}
