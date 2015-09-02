<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDecimalFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::table('users_points', function(Blueprint $table)
        {
           $table->decimal('added_points',18,4)->nullable()->after('description');
            $table->decimal('substracted_points',18,4)->nullable()->after('added_points');
            $table->decimal('balance',18,4)->nullable()->after('substracted_points');
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
