<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsOnApiSearchMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_storage_master', function($table)
		{
		    $table->renameColumn('loadging_type', 'lodging_type');
		    $table->renameColumn('loadging_stars', 'lodging_stars');
		    $table->renameColumn('loadging_hotel_name', 'lodging_hotel_name');
		    $table->renameColumn('cruise_lenght', 'cruise_length');

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
    }
}
