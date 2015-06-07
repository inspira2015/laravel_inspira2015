<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserRedeemCodes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('user_reedem_codes', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('inspirausers_id');
			$table->integer('codes_id');
			$table->timestamp('code_exp_date');
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
		Schema::drop('user_reedem_codes');

	}

}
