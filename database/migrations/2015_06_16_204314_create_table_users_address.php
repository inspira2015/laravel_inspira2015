<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsersAddress extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('users_address', function(Blueprint $table)
		{
			$table->bigIncrements('id')->unsigned();
			$table->bigInteger('users_id')->unsigned();
			$table->string('type',15);
			$table->string('address',200);
			$table->string('address2',200)->nullable();
			$table->string('city',200)->nullable();
			$table->string('state',200)->nullable();
			$table->string('country',200)->nullable();
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
		Schema::drop('users_address');

	}

}
