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
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigIncrements('id')->unsigned();
			$table->string('leisure_id' , 20)->nullable();
			$table->string('email',255);
			$table->string('password',60);
			$table->tinyInteger('active')->default(1);
			$table->string('remember_token',100)->nullable();
			$table->string('name',150);
			$table->string('last_name',150);
			$table->tinyInteger('confirmed')->default(1);
//			$table->string('confirmation_code',100)->nullable();
			$table->string('language',15)->default('MX');
			$table->timestamps();
			$table->unique('email');
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
		Schema::drop('users');

	}

}
