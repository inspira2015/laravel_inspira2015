<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

	protected $table = 'users';
	protected $primaryKey = 'id';

	public function vacation_fund_log(){
		return $this->hasMany('App\Model\VacationFundLog', 'users_id', 'id');
	}
	
	public function vacational_funds(){
		return $this->hasMany('App\Model\UserVacationalFunds', 'users_id', 'id');
	}
	
	// Check these (aff-addr-phones-codes) relationship - ER
	public function affiliations(){
		return $this->hasOne('App\Model\UserAffiliations', 'users_id', 'id');
	}
	
	public function address(){
		return $this->hasOne('App\Model\UserAddress', 'users_id', 'id');
	}
	
	public function phones(){
		return $this->hasMany('App\Model\UserRegisteredPhones', 'users_id', 'id');
	}
	
	public function logs(){
		return $this->hasMany('App\Model\SystemLog', 'users_id', 'id');
	}
	
	public function code_used(){
		return $this->hasOne('App\Model\CodesUsed', 'users_id', 'id');
	}
	
	public function password_resets(){
		return $this->hasMany('App\Model\PasswordResets', 'email', 'email');
	}
}
