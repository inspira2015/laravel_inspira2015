<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RegisteredCodes extends Model {

	protected $table = 'registered_codes';

	protected $fillable = ['code','users_id'];
	
/*
	public function code(){
		return $this->belongsTo('App\Model\Code', 'codes_id', 'id');
	}
*/
	public function user(){
		return $this->belongsTo('App\Model\User', 'users_id', 'id');
	}
	
}
