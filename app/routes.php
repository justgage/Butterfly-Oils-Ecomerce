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
 * Backend!
 *****************************/
Route::get('login', array("as" => 'login', 'uses' => 'UserController@login'));
Route::post('backend/check', array("as" => 'backend.check', 'uses' => 'UserController@check'));

//for AUTH protected routes. 
Route::group(array('before' => 'auth'), function() {
    Route::get('backend', array("as" => 'backend.index', 'uses' => 'UserController@index'));
    Route::get('backend/category', array("as" => 'backend.category', 'uses' => 'UserController@category'));
    Route::get('backend/logs', array("as" => 'backend.logs', 'uses' => 'LogsController@index'));
});

Route::get('backend/logout', array("as" => 'backend.logout', 'uses' => 'UserController@logout'));

/******************************
 * Cart
 *****************************/
Route::controller('cart', 'CartController');

/******************************
 * PayPal
 *****************************/
//Route::controller('payment', 'PaypalPaymentController');

/* USE HTTPS when we are on a real server!!! */
Route::get('paypal', array('as' => 'paypal.create', 'uses' => 'PaypalPaymentController@createPaypal'));
Route::get('paypal/execute', array('as' => 'paypal.execute', 'uses' => 'PaypalPaymentController@execute'));

//Route::get('paypal', array('https', 'as' => 'paypal.create', 'uses' => 'PaypalPaymentController@createPaypal'));
// Route::get('paypal/execute', array('https', 'as' => 'paypal.execute', 'uses' => 'PaypalPaymentController@execute'));


/******************************
 * Oils
 * Categorys
 * Tags
 *****************************/

Route::resource('oils', 'OilController', 
    array('except' => [ 'show' ]) );

Route::resource('shop/uses', 'TagController', 
    array('except' => [ 'show' ]) );

Route::resource('cats', 'CatController', 
    array('except' => [ 'show', 'index' ]) );

//Categorys 
Route::get('shop/categories', ['as' => 'cats.index', 'uses' => 'CatController@index']);

// Tags show
Route::post('shop/uses/ajax_list', ['as' => 'tags.ajax', 'uses' => 'TagController@ajax_list']);
Route::get('shop/uses/{tagId}', ['as' => 'tags.show', 'uses' => 'TagController@show']);

//Cat index
Route::get('shop/{catId}', ['as' => 'cats.show', 'uses' => 'CatController@show']);

//Oils
Route::get('shop/{catId}/{oilId}', ['as' => 'oils.show', 'uses' => 'OilController@show']);
Route::get('ship/oils/delete/{id}', ['as' => 'oils.delete', 'uses' => 'OilController@delete']);
Route::get('ship/oils/restore/{id}', ['as' => 'oils.restore', 'uses' => 'OilController@restore']);
Route::get('ship/oils/delete-all', ['as' => 'oils.deleteAll', 'uses' => 'OilController@deleteAll']);

