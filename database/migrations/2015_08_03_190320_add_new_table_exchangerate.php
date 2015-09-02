<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewTableExchangerate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('exchange_rate', function(Blueprint $table)
        {
            $table->bigIncrements('id')->unsigned();
            $table->string('exchange_type' , 20);
            $table->date('exchange_date');
            $table->double('exchange_rate',15,6);
            $table->timestamps();
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
        Schema::drop('exchange_rate');

    }
}
