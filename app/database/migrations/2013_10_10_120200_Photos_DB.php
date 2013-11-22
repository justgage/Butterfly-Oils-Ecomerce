<?php

use Illuminate\Database\Migrations\Migration;

class PhotosDB extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
      Schema::create('photos', function($table) {
         $table->increments('id');
         $table->string('path')->unique();
         $table->integer('oil_id');
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
      Schema::drop('photos');

      $files = glob('public/uploads/*'); // get all file names
      foreach($files as $file){ // iterate files
         if(is_file($file))
            echo "removing image " . $file . "\n";
            unlink($file); // delete file
      }
	}

}
