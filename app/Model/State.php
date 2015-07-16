<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class State extends Model 
{
	protected $table = 'states';
	
	public function country(){
		return $this->belongsTo('App\Model\Country', 'country', 'code');
	}
}