<?php 
class UserController extends \BaseController {

  public function index() {
    $oils = Oil::all();
    return View::make("backend.index")
        ->with([
            "title" => "Backend",
            "pretty_url" => $this->pretty_url(),
            "oils" => $oils
        ]);
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

  public function category() {
      $cats = Cat::all();
      return View::make("backend.category")
        ->with([
            "title" => "Backend categories",
            "pretty_url" => $this->pretty_url(),
            "cats" => $cats,
            "tab" => 1
        ]);
  }

} // end of UserController

?>
