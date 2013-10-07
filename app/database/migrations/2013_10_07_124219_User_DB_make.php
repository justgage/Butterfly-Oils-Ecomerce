<?php

use Illuminate\Database\Migrations\Migration;

class UserDBMake extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function($table) {
      $table->increments('id');
      $table->string('username')->unique();
      $table->string('email')->unique();
      $table->string('password');
      $table->integer('rights'); // 0 - admin, 1 - user
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
    Schema::drop('users');
  }

}
