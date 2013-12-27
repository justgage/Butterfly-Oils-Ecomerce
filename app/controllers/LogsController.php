<?php
class LogsController extends BaseController {

    public function index() {
        if (Auth::check()) {
            $logs = PayLog::all();
            return View::make('backend.logs')
                ->with('title', 'Purchase logs')
                ->with('logs', $logs)
                ->with('tab', 2);
        } else {
            return Redirect::route('oils.index')
                ->with('message' , "Sorry you don't have rights to create a Category, please login");
        }

    }


}
