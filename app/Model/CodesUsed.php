<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CodesUsed extends Model {

	protected $table = 'codes_used';

	protected $fillable = ['codes_id','users_id'];
	
	public function code(){
		return $this->belongsTo('App\Model\Code', 'codes_id', 'id');
	}
	
	public function user(){
		return $this->belongsTo('App\Model\User', 'users_id', 'id');
	}
	
}
