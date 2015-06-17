<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVacationFundLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('vacation_fund_log', function(Blueprint $table)
		{
			$table->bigIncrements('id')->unsigned();
			$table->bigInteger('users_id')->unsigned();
			$table->decimal('amount',10,2);
			$table->tinyInteger('active')->default(1);
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
		Schema::drop('vacation_fund_log');
	}

}
