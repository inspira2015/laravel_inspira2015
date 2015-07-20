<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Affiliations extends Model {

	protected $table = 'affiliations';
	
	protected $fillable = ['name_es', 'name_eng', 'small_desc_es','small_desc_eng','tier_id'];

	public function user_affiliation()
	{
		return $this->hasOne('App\Model\UserAffiliations', 'affiliations_id', 'id');
	}

	public function affiliations_description()
	{
		return $this->hasMany('App\Model\AffiliationsDescription', 'affiliations_id', 'id');
	}
	
}
