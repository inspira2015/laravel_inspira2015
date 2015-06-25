<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToUserRegisteredPhonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_registered_phones', function(Blueprint $table)
		{
			$table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_registered_phones', function(Blueprint $table)
		{
			$table->dropForeign('users_registered_phones_users_id_foreign');
		});
	}

}
