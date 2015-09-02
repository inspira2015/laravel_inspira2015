<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApiSearchTour extends Model 
{
	protected $table = 'api_search_tours';
	
	protected $fillable = ['leisure_id','users_id', 'destination','tour_type','search_date','key_words'];

}