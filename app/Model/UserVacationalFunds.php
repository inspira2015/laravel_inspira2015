<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserVacationalFunds extends Model {

	protected $table = 'users_vacational_funds';

	public function user(){
		return $this->belongsTo('App\Model\User', 'users_id', 'id');
	}

}
