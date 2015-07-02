<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model {

	protected $table = 'users_address';
	
	public function user(){
		return $this->belongsTo('App\Model\User', 'users_id', 'id');
	}

}
