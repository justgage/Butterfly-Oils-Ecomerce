<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$this->call('OilTableSeeder');
	}

}

class OilTableSeeder extends Seeder {
	public function run() {
        DB::table('oils')->delete();

        for($i=0; $i < 10; $i++ ) {
            $oil = new Oil;

            $oil->name = "Lavender" . $i;
            $oil->info = "This is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala bla";
            $oil->price = 10.05;
            $oil->compare_price = 9.05;

            $oil->save();
        }
    }

}
