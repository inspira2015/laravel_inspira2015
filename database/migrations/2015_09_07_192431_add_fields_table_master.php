<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsTableMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('api_storage_master', function($table)
        {
            $table->decimal('booking_amount',18,2)->nullable()->after('key_words');
            $table->timestamp('booking_date')->nullable()->after('booking_amount');
            $table->string('booking_payment_type',25)->nullable()->after('booking_date');
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
         Schema::table('api_storage_master', function($table)
        {
            $table->dropColumn('booking_amount');
            $table->dropColumn('booking_date');
            $table->dropColumn('booking_payment_type');

        });
    }
}
