<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAffiliationPayment extends Model {

	protected $table = 'users_affiliations_payments';

	protected $fillable = ['users_id', 'charge_at', 'transaction_id', 'affiliations_id', 'currency',  'payu_transaction_id'];

	


}
