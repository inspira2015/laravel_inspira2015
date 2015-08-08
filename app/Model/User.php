<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract 
{

	use Authenticatable, CanResetPassword;
	protected $table = 'users';
	protected $primaryKey = 'id';
	//All filable cause its used on update to fill
	protected $fillable = ['leisure_id','email', 'password', 'active','remember_token', 'name', 'last_name','confirmed','language',
						    'confirmation_code','country','state','facebook_id','facebook_link','gender','facebook_avatar'];

	public function funds_log(){
		return $this->hasMany('App\Model\VacationFundLog', 'users_id', 'id');
	}
	
	public function funds(){
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

	public function user_payment_info(){
		return $this->hasOne('App\Model\UserPaymentInfo', 'users_id', 'id');
	}


}
