<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAmountSystemTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
           Schema::table('system_transactions', function(Blueprint $table)
        {
            $table->dropColumn('amount');
            
        });

        Schema::table('system_transactions', function(Blueprint $table)
        {
           $table->decimal('amount',18,4)->nullable()->after('json_data');
           
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
