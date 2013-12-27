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
            $table->string('payment_id');

            $table->boolean('viewed')->default(false);

            $table->string('state')->default('unfinished!');

            $table->string('paypal_id')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('payer_first_name')->nullable();
            $table->string('payer_last_name')->nullable();

            $table->text('shipping_address')->nullable();   // json
            $table->text('item_list')->nullable();          // json
            $table->float('total')->nullable();
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
