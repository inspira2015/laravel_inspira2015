<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsUserAffiliations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users_affiliations', function($table)
        {
            $table->decimal('amount',8,4)->nullable()->after('active');
            $table->string('currency',8)->nullable()->after('amount');
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
         Schema::table('users_affiliations', function($table)
        {
            $table->dropColumn('amount');
            $table->dropColumn('currency');

        });
    }
}
