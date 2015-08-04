<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model 
{
	protected $table = 'exchange_rate';
	
	protected $fillable = ['exchange_type', 'exchange_date', 'exchange_rate'];
	
}