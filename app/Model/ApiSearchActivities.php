<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApiSearchActivities extends Model 
{
	protected $table = 'api_search_activities';
	
	protected $fillable = ['leisure_id','users_id', 'destination','category','search_date','key_words'];

}