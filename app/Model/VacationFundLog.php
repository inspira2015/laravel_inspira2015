<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VacationFundLog extends Model {

	protected $table = 'vacation_fund_log';
	
	public function user(){
		return $this->belongsTo('App\Model\User', 'users_id', 'id');
	}

}
