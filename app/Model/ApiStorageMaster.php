<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApiStorageMaster extends Model 
{
	protected $table = 'api_storage_master';
	
	protected $fillable = ['leisure_id','users_id', 'data_type','api_type','lodging_type','flight_type',
	'car_type','activity_category','tour_type','search_date','from','destination','start_date','end_date','adult_number',
	'child_number','cruise_line','cruise_name','cruise_length','lodging_stars','lodging_hotel_name','flight_air_line',
	'flight_airfare','payment_type','booking_amount','booking_date','booking_payment_type' ,'key_words'];



}