<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInspirausers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('inspirausers', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('leisure_id' , 20);
			$table->string('email',20);
			$table->string('password',40);
			$table->string('first_name',200);
			$table->string('last_name',200);
			$table->string('home_phn',20);
			$table->string('wrk_phn',20);
			$table->string('address',240);
			$table->string('address2',240);
			$table->string('city',50);
			$table->string('country',50);
			$table->string('state',50);
			$table->string('code',50);
			$table->tinyInteger('fondo');
			$table->double('amount');
			$table->string('language',10);
			$table->timestamp('expirationDate');
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
		Schema::drop('inspirausers');

	}

}
