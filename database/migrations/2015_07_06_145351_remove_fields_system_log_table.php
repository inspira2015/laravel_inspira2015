<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldsSystemLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('system_log', function (Blueprint $table) {
			$table->dropColumn('type_of_transaction');
			$table->dropColumn('table');	
			$table->dropColumn('text');			
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
            $table->string('type_of_transaction',255);
			$table->string('table',200);
			$table->string('text')->nullable();
        });
    }
}
