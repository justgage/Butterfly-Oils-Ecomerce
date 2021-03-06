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
            $table->string('name');
            $table->string('urlName')->unique();
            $table->text('info');
            $table->boolean('visible');
            $table->timestamps();
        });

        // Create a category to stick any oils that 
        // that get their category deleted. 
        $cat = new Cat;

        $cat->name = "Other";
        $cat->urlName = "other";
        $cat->info = "A place to put oils when their category is deleted.";
        $cat->visible = false;

        $cat->save();
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
