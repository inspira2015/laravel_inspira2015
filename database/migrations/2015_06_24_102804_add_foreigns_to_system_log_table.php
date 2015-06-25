<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToSystemLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('system_log', function(Blueprint $table)
		{
			$table->foreign('users_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('system_log', function(Blueprint $table)
		{
			$table->dropForeign('system_log_users_id_foreign');
		});
	}

}
