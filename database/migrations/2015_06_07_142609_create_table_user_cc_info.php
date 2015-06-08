<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserCcInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('user_cc_info', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('inspirausers_id');
			$table->string('number',50);
			$table->string('name_on_card',50);
			$table->string('cvv',10);
			$table->string('exp_month',4);
			$table->string('exp_year',4);
			$table->string('address',100);
			$table->string('address2',100);
			$table->string('state',100);
			$table->string('city',100);
			$table->string('country',100);
			$table->string('postal_code',100);
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
		Schema::drop('user_cc_info');

	}

}
