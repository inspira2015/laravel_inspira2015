<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToLoading extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::table('api_search_loadging', function(Blueprint $table)
        {
            $table->string('destiny',100)->nullable()->after('type');

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
         Schema::table('api_search_loadging', function($table)
        {
            $table->dropColumn('destiny');

        });
    }
}
