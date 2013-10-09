<?php

use Illuminate\Database\Migrations\Migration;

class SetupDB extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oils', function($table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('info');
            $table->float('price');
            $table->float('compare_price');
            $table->timestamps();
        });

        Schema::create('photos', function($table) {
            $table->increments('id');
            $table->string('caption');
            $table->string('path')->unique();
            $table->integer('oil_id')->unique();
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
        Schema::drop('oils');
        Schema::drop('photos');
    }

}

