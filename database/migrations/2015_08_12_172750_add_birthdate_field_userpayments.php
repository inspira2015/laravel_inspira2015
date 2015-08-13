<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBirthdateFieldUserpayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('users_payment_info', function(Blueprint $table)
        {
            $table->date('birthdate')->nullable()->after('name_on_card');

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
        Schema::table('users_payment_info', function($table)
        {
            $table->dropColumn('birthdate');
        });

    }
}
