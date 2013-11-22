<?php

use Illuminate\Database\Migrations\Migration;

class TagsMake extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //schema for the tags table
        Schema::create('tags', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('urlName');
            $table->timestamps();
        });

        // table between oils and tags
        Schema::create('oil_tag', function($table) {
            $table->integer('oil_id');
            $table->integer('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tags');
        Schema::drop('oil_tag');
    }

}
