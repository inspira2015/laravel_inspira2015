<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Code extends Model {

	/**
	* The database table Code by the model.
	*
	* @var string
	*/
	protected $table = 'codes';
	
	protected $fillable = ['code', 'currency', 'end_date'];



}
