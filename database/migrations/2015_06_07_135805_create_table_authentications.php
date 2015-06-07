<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAuthentications extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('authentications', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('inspirausers_id');
			$table->string('provider',100);
			$table->string('provider_uid',255);
			$table->string('email',200);
			$table->string('display_name',150);
			$table->string('first_name',100);
			$table->string('last_name',100);
			$table->string('profile_url',255);
			$table->string('website_url',255);
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
		Schema::drop('authentications');

	}

}
