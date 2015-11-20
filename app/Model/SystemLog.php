<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model {

	protected $table = 'system_log';
	protected $primaryKey = 'id';

	protected $fillable = ['users_id', 'model', 'action', 'method', 'description'];
	public function user(){
		return $this->belongsTo('App\Model\User', 'users_id', 'id');
	}

}
