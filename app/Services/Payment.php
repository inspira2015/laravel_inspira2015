<?php 
namespace App\Services;

use Validator;
use Auth;
use App\Model\ExchangeRate;
class Payment
{
	private $messages;
	private $exchange;
	protected $todayExchange;


	public function validatorMXN(array $data, $lang) {
		$this->messages = [
			'en' => [
			],
			'es' => [
				'amount.required' => 'La cantidad es requerida.',
				'amount.numeric' => 'La cantidad sólo puede contener números.',
				'amount.min' => 'La cantidad mínima es de :min MXN.',
 				'amount.max' => 'La cantidad máxima es de :max MXN.'
			]
		];
		
		return Validator::make($data, [
			'amount' => 'numeric|required|min:40|max:10000',
			'currency' => 'in:MXN'

		],  $this->messages[$lang]);
	}

	
	public function validatorUSD(array $data, $lang) {
		$this->exchange = new ExchangeRate();

		$this->todayExchange =  $this->exchange->orderBy('id','desc')->first();
		$this->messages = [
			'en' => [
			],
			'es' => [
				'amount.required' => 'La cantidad es requerida.',
				'amount.numeric' => 'La cantidad sólo puede contener números.',
				'amount.min' => 'La cantidad mínima es de :min USD',
 				'amount.max' => 'La cantidad máxima es de :max USD.'
			]
		];
		
		return Validator::make($data, [
			'amount' => 'numeric|required|min:3|max:'.$this->getMax($this->todayExchange->exchange_rate),
			'currency' => 'in:USD'

		],  $this->messages[$lang]);
	}
	
	private function getMax( $exchange_rate ){
		return floor(10000/$exchange_rate);
	}
}
