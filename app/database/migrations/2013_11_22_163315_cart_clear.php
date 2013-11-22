<?php

use Illuminate\Database\Migrations\Migration;

class CartClear extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// nothing
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        if ( Cart::destroy() ) {
            echo "cart was cleared";
        } else {
            echo "ERROR: cart was NOT cleared\n";
        }
	}

}
