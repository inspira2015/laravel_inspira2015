<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToAuthenticationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('authentications', function(Blueprint $table)
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
		Schema::table('authentications', function(Blueprint $table)
		{
			$table->dropForeign('authentications_users_id_foreign');
		});
	}

}
