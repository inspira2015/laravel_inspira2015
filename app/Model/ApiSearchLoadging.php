<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApiSearchLoadging extends Model 
{
	protected $table = 'api_search_loadging';
	
	protected $fillable = ['leisure_id','users_id', 'data_type', 'type','destiny','start_date','end_date', 'adult_number','child_number','stars','hotel_name','key_words'];

}