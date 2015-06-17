<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsersPoints extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('users_points', function(Blueprint $table)
		{
			$table->bigIncrements('id')->unsigned();
			$table->bigInteger('users_id')->unsigned();
			$table->string('description',255);
			$table->decimal('added_points',5,4);
			$table->decimal('substracted_points',5,4);
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
		Schema::drop('users_points');
	}

}
