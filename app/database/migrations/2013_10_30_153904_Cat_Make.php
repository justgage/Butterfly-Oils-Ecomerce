<?php

use Illuminate\Database\Migrations\Migration;

class CatMake extends Migration {


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cats', function($table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('info');
            $table->boolean('visible');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cats');
    }


}
