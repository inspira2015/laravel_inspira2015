<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApiSearchFlight extends Model 
{
	protected $table = 'api_search_flights';
	
	protected $fillable = ['leisure_id','users_id','data_type','from','where','type','start_date','end_date','adult_number','child_number','air_line','airfare','key_words'];

}