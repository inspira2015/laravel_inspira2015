<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApiSearchCar extends Model 
{
	protected $table = 'api_search_cars';
	
	protected $fillable = ['leisure_id','users_id', 'from','start_date','where','end_date', 'car_type','payment_type','key_words'];

}