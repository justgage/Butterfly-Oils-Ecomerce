<?php

Route::get('remember/{user}/{pass}, function ($user, $pass) {
	$credentials = [
        	"username" => Input::get("username"),
        	"password" => Input::get("password")
      	];

	if (Auth::attempt($credentials)) {
        	return 'It worked.';
    	} else {
        	return 'It does not work.';
	}
};

Route::get('checksession', function()
{	
	return Session::all();
});

}
