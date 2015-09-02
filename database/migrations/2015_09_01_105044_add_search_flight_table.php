<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSearchFlightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('api_search_flights', function(Blueprint $table)
        {
            $table->bigIncrements('id')->unsigned();
            $table->string('leisure_id' , 20);
            $table->bigInteger('users_id')->unsigned();
            $table->string('from',150)->nullable();
            $table->string('where',150)->nullable();
            $table->string('type',25)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('adult_number')->default(0)->nullable();
            $table->tinyInteger('child_number')->default(0)->nullable();
            $table->string('air_line',200)->nullable();
            $table->string('airfare',200)->nullable();
            $table->text('key_words')->nullable();
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
        Schema::drop('api_search_flights');

    }
}
