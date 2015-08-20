<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDecimalFieldsVacationalfund extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('users_vacational_funds', function(Blueprint $table)
        {
            $table->dropColumn('added_amount');
            $table->dropColumn('substracted_amount');
            $table->dropColumn('balance');
        });

        Schema::table('users_vacational_funds', function(Blueprint $table)
        {
           $table->decimal('added_amount',18,4)->nullable()->after('description');
            $table->decimal('substracted_amount',18,4)->nullable()->after('added_amount');
            $table->decimal('balance',18,4)->nullable()->after('substracted_amount');
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
