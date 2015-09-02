<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::create('api_search_tours', function(Blueprint $table)
        {
            $table->bigIncrements('id')->unsigned();
            $table->string('leisure_id' , 20);
            $table->bigInteger('users_id')->unsigned();
            $table->string('destination',150)->nullable();
            $table->string('tour_type',240)->nullable();
            $table->timestamp('search_date')->nullable();
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
        Schema::drop('api_search_tours');

    }
}
