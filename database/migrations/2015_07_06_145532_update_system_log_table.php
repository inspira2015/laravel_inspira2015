<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSystemLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('system_log', function (Blueprint $table) {
	        $table->string('module',255);
			$table->string('action',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('system_log', function (Blueprint $table) {
	        $table->dropColumn('module');
			$table->dropColumn('action');
        });
    }
}
