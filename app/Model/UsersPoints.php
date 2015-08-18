<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsersPoints extends Model {

	protected $table = 'users_points';
	protected $fillable = array('users_id', 'transaction_id', 'description','added_points', 'substracted_points','balance');
	
	public function user(){
		return $this->belongsTo('App\Model\User', 'users_id', 'id');
	}

}
