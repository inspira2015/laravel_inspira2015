<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCodesUsed extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('codes_used', function(Blueprint $table)
		{
			$table->bigIncrements('id')->unsigned();
			$table->integer('codes_id')->unsigned();
			$table->bigInteger('users_id')->unsigned();
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
		Schema::drop('codes_used');

	}

}
