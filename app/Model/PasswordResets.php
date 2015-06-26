<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model {

	protected $table = 'password_resets';
	
	public function user(){
		return $this->belongsTo('App\Model\User', 'email', 'email');
	}

}
