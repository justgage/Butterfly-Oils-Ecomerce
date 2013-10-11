<?php

use Illuminate\Database\Migrations\Migration;

class OilsDB extends Migration {

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
            $table->booleen('visible');

            $table->timestamps();
            $table->softDeletes();
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
    }

}
