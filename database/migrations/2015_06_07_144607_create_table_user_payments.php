<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserPayments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('user_payments', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('inspirausers_id');
			$table->decimal('amount',6,2);
			$table->string('currency',15);
			$table->string('payment_code',15);
			$table->string('status',15);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('user_payments');

	}

}
