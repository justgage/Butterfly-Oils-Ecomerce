<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/******************************
 * Homepage
 *****************************/
Route::get('/', array("as" => "home", function() 
{
	return View::make('front.index')->with(['title' => 'Welcome to Buttefly Oils!']);
}));


/******************************
 * Oils Controller
 *****************************/
Route::resource('oils', 'OilController');

/******************************
 * Backend!
 *****************************/
Route::get('login', array("as" => 'login', 'uses' => 'UserController@login'));
Route::post('backend/check', array("as" => 'backend.check', 'uses' => 'UserController@check'));
Route::group(array('before' => 'auth'), function() {
    Route::get('backend', array("as" => 'backend.index', 'uses' => 'UserController@index'));
  });
Route::get('backend/logout', array("as" => 'backend.logout', 'uses' => 'UserController@logout'));

/******************************
 * Cart
 *****************************/
Route::get('cart/add', function() {
   $id = Input::get('id');

   $oil = Oil::find($id);
   
   Cart::add($oil->id, $oil->name, 1, $oil->price);

   $cart = Cart::content()->toArray();

   $row_id = Cart::search(array('id' => $id));

   $qty = $cart[$row_id[0]]['qty'];
   $total = $cart[$row_id[0]]['price'] * $qty;

   return json_encode(array('mess' => "$oil->name was added now ". $qty . " items = $$total", 'cart' => $cart));
});
