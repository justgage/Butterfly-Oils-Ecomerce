<?php

use Illuminate\Database\Migrations\Migration;

class PayLogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        //schema for the tags table
        Schema::create('payLogs', function($table) {
            $table->increments('id');

            $table->string('state');

            $table->string('paypal_id');
            $table->string('payer_email');
            $table->string('payer_id');
            $table->string('payer_first_name');
            $table->string('payer_last_name');

            $table->text('shipping_address');   // json
            $table->text('item_list');          // json
            $table->float('total');
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
        Schema::drop('payLogs');
	}

}
