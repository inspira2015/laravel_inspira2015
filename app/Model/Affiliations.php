<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Affiliations extends Model {

	protected $table = 'affiliations';
	
	public function user_affiliation(){
		return $this->hasOne('App\Model\UserAffiliations', 'affiliations_id', 'id');
	}
	
}
