<?php

use Illuminate\Database\Migrations\Migration;

class Page extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('pages', function($table) {
            $table->increments('id');
            $table->boolean('visible');
            $table->string('name');
            $table->string('urlName');
            $table->integer('order');
            $table->text('content');
            $table->text('contentHTML');
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
        Schema::drop('pages');
	}

}
