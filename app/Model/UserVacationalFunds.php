<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserVacationalFunds extends Model {

	protected $table = 'users_vacational_funds';
	protected $fillable = array('users_id', 'transaction_id', 'description','added_amount','substracted_amount','balance','currency');

	public function user(){
		return $this->belongsTo('App\Model\User', 'users_id', 'id');
	}

}
