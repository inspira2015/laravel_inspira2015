<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Country extends Model 
{
	protected $table = 'countries';
	
	public function state(){
		return $this->hasMany('App\Model\State', 'country', 'code');
	}
	
}