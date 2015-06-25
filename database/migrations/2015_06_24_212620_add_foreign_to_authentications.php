<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToAuthentications extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('authentications', function(Blueprint $table)
		{
			$table->bigInteger('users_id')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('authentications', function(Blueprint $table)
		{
			$table->dropColumn('users_id');
		});
	}

}
