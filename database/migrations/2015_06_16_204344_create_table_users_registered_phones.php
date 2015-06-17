<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsersRegisteredPhones extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('users_registered_phones', function(Blueprint $table)
		{
			$table->bigIncrements('id')->unsigned();
			$table->bigInteger('users_id')->unsigned();
			$table->string('type',15);
			$table->string('number',15);
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
		Schema::drop('users_registered_phones');

	}

}
