<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

	class SystemTransaction extends Model 
	{

		/**
		* The database table Code by the model.
		*
		* @var string
		*/
		protected $table = 'system_transactions';
	
		protected $fillable = ['users_id', 'code', 'type', 'description', 'amount', 'currency', 'payu_transaction_id'];
	
	
}
