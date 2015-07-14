<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersVacationalFundTable extends Migration
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
            $table->renameColumn('added_points', 'added_amount');
            $table->renameColumn('substracted_points', 'substracted_amount');

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
        Schema::table('users_vacational_funds', function(Blueprint $table)
        {
            $table->renameColumn('substracted_amount', 'substracted_points');
            $table->renameColumn('added_amount', 'added_points');
        });

    }
}
