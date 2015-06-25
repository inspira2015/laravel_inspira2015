<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToUserAddressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_address', function(Blueprint $table)
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
		Schema::table('user_address', function(Blueprint $table)
		{
			$table->dropForeign('users_address_users_id_foreign');
		});
	}

}
