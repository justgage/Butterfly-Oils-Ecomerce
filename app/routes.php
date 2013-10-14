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

Route::get('/', array("as" => "home", function() 
{
	return View::make('front.index')->with(['title' => 'Welcome to Buttefly Oils!']);
}));

Route::post('cart_add', function() {
   $id = Input::get('id');
   return json_encode(array('mess' => "$id was added"));
});

Route::resource('oils', 'OilController');

Route::get('login', array("as" => 'login', 'uses' => 'UserController@login'));
Route::post('backend/check', array("as" => 'backend.check', 'uses' => 'UserController@check'));

Route::group(array('before' => 'auth'), function() {
    Route::get('backend', array("as" => 'backend.index', 'uses' => 'UserController@index'));
  });

Route::get('backend/logout', array("as" => 'backend.logout', 'uses' => 'UserController@logout'));





