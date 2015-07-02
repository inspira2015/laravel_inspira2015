<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserRegisteredPhones extends Model {

	protected $table = 'users_registered_phones';
	
	public function user(){
		return $this->belongsTo('App\Model\User', 'users_id', 'id');
	}

}
