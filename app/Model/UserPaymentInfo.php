<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

	class UserPaymentInfo extends Model 
	{

		/**
		* The database table Code by the model.
		*
		* @var string
		*/
		protected $table = 'users_payment_info';
	
		protected $fillable = ['users_id', 'token', 'name_on_card', 'payment_method', 'address', 'address2','city', 'state', 'zip_code', 'country'];
	
		public function user(){
			return $this->hasOne('App\Model\User', 'users_id', 'id');
		}

}
