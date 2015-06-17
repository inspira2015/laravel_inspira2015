<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsersAffiliations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('users_affiliations', function(Blueprint $table)
		{
			$table->bigIncrements('id')->unsigned();
			$table->bigInteger('users_id')->unsigned();
			$table->integer('affiliations_id')->unsigned();
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
		Schema::drop('users_affiliations');

	}

}
