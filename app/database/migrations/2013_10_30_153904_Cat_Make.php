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
            $table->string('urlName')->unique();
            $table->text('info');
            $table->boolean('visible');
            $table->timestamps();
        });

        // Create a category to stick any oils that 
        // that get their category deleted. 
        $cat = new Cat;

        $cat->id = 0;
        $cat->name = "Other";
        $cat->urlName = "other";
        $cat->info = "All the other products";
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
