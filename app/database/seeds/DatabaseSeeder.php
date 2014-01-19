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
		$this->call('CatTableSeeder');
		$this->call('OilTableSeeder');
	}

}

class CatTableSeeder extends Seeder {
	public function run() {

        $cat_list  = array(
            "Singles" => "A bottle of oil, containing only one pure essential oil. ",
            "Blends" => "A powerful blends of different essential oils.",
            "Cases" => "Cases to protect the oils"
        );

        foreach ($cat_list as $name => $info){
            $cat = new Cat;

            $cat->name = $name;
            $cat->urlName = strtolower($name);
            $cat->info = $info;
            $cat->visible = true;

            $cat->save();
        }

    }

}
class OilTableSeeder extends Seeder {
	public function run() {
        DB::table('oils')->delete();

        $cat = Cat::where('name', '=', 'Other')->first(); // 'other' category

        for($i=0; $i < 10; $i++ ) {
            $oil = new Oil;

            $oil->name = "Lavender" . $i;
            $oil->urlName = "lavender_$i";
            $oil->info = "This is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala blaThis is about the oil. bala bla";
            $oil->price = 10.05;
            $oil->compare_price = 9.05;
            $oil->visible = true;

            $oil->cat()->associate($cat);

            $oil->save();
        }

        // $user = new User;
        // $user->username = "admin";
        // $user->password = Hash::make('password');
        // $user->email =  str_random(10) . "@gmail.com";
        // $user->rights = 0;
        // $user->save();
    }

}
