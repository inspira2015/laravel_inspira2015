<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewTableMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('api_storage_master', function(Blueprint $table)
        {
            $table->bigIncrements('id')->unsigned();
            $table->string('leisure_id' , 20);
            $table->bigInteger('users_id')->unsigned();
            $table->string('data_type',15)->nullable();
            $table->string('api_type',15)->nullable();
            $table->string('loadging_type',25)->nullable();
            $table->string('flight_type',25)->nullable();
            $table->string('car_type',25)->nullable();
            $table->string('activity_category',240)->nullable();
            $table->string('tour_type',240)->nullable();
            $table->timestamp('search_date')->nullable();
            $table->string('from',150)->nullable();
            $table->string('destination',150)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('adult_number')->default(0)->nullable();
            $table->tinyInteger('child_number')->default(0)->nullable();
            $table->string('cruise_line',150)->nullable();
            $table->string('cruise_name',150)->nullable();
            $table->decimal('cruise_lenght',8,2)->nullable();
            $table->decimal('loadging_stars',8,2)->nullable();
            $table->string('loadging_hotel_name',200)->nullable();
            $table->string('flight_air_line',200)->nullable();
            $table->string('flight_airfare',200)->nullable();
            $table->string('payment_type',50)->nullable();       
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
    }
}
