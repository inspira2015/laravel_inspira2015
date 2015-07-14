<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAffiliations extends Model 
{

	protected $table = 'users_affiliations';
	
	public function user()
	{
		return $this->belongsTo('App\Model\User', 'users_id', 'id');
	}
	
	public function affiliation()
	{
		return $this->belongsTo('App\Model\Affiliations', 'affiliations_id', 'id');
	}

	protected $fillable = ['users_id','affiliations_id', 'active'];

}
