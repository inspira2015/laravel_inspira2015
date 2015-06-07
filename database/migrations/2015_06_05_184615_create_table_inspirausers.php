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
			$table->string('leisure_id' , 20)->nullable();
			$table->string('email',20);
			$table->string('password',40);
			$table->string('first_name',200);
			$table->string('last_name',200);
			$table->string('home_phn',20)->nullable();
			$table->string('wrk_phn',20)->nullable();
			$table->string('address',240)->nullable();
			$table->string('address2',240)->nullable();
			$table->string('city',50);
			$table->string('country',50);
			$table->string('state',50);
			$table->string('code',50)->nullable();
			$table->tinyInteger('fondo');
			$table->double('amount')->nullable();
			$table->string('language',10)->nullable();
			$table->timestamp('expirationDate')->nullable();
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
