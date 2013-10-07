<?php 
class UserController extends \BaseController {

  public function index() {
    return View::make("backend.index")->with(["title"=> "Backend"]);
  }

  public function login() {
    if (Auth::check()) {
      return Redirect::route("backend.index");
    } else {
      return View::make('backend.login')->with([ 'title' => 'Login' ]);
    }
  }

  public function check() {
    $credentials = [
      "username" => Input::get("username"),
        "password" => Input::get("password")
      ];
    if (Auth::attempt($credentials))
    {
      return Redirect::route("backend.index");
    }
    else {
      return Redirect::route('login')->withInput(Input::except('password'))->with([ 'message' => 'Bad Password or Username', 'title' => 'Login' ]);
    }
  }

  public function logout() {
    Auth::logout();
    return Redirect::to('/')->with(['message'=>'Logged out']);
  }
} 

?>
