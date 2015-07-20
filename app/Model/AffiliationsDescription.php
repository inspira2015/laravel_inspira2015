<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

	class AffiliationsDescription extends Model 
	{

		/**
		* The database table Code by the model.
		*
		* @var string
		*/
		protected $table = 'affiliations_description';
	
		protected $fillable = ['affiliations_id', 'description_es', 'description_en'];
	
		public function affiliations()
		{
			return $this->belongsTo('App\Model\Affiliations', 'affiliations_id', 'id');
		}

}
