<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApiUsersReservations extends Model 
{
	protected $table = 'api_users_reservations';
	
	protected $fillable = ['leisure_id', 'extra', 'confirmation_code'];

}