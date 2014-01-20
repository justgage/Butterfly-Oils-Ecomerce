<?php

class PageController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $pages = InfoPage::all();

        return View::make('backend.page')
            ->with("title", "Pages list")
            ->with("pages", $pages);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        if (Auth::check()) {
            return View::make('pages.create')
                ->with('title', 'Creating a page');

        } else {
            return Redirect::route('home')
                ->with('message' , "Sorry you don't have rights to do that. Please login.");
        }
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
        if (Auth::check() === false) { // if NOT Authenticated

            return Redirect::route('pages.index')
                ->with('message' , "Sorry you don't have rights to create a Category, please login");

        } else { // We are loged in as admin

        $valid = InfoPage::validate(Input::all());

        if ($valid->fails()) {
            return Redirect::route('pages.create')
                ->withErrors($valid)
                ->withInput();
        }

        $page = new InfoPage;

        $page->name = Input::get('name');
        $page->urlName = $this->safeUrl(Input::get('name'));
        $page->content = Input::get('content');
        $page->contentHTML = Purifier::clean(Markdown::instance()->set_breaks_enabled(true)->parse(Input::get('content')));
        $page->order = Input::get('order');
        $page->visible = true == Input::get('visible');

        $page->save();

        return Redirect::route('backend.page')
            ->with('message', 'Page ' . $page->name . ' was created sucsessfuly');
        }

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($urlName)
	{
        $page = InfoPage::where('urlName', '=', $urlName)->first();

        if ($page === null) {
            return $this->missingMethod();
        } else {
            return View::make('pages.show')
                ->with('page', $page)
                ->with('title', $page->name);
        }

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        if (Auth::check()) {
            $page = InfoPage::find($id);
            if ($page !== null) {
                return View::make('pages.edit', $page)
                    ->with('page', $page)
                    ->with('title', 'Editing a page');
            } else {
                return Redirect::route('backend.page')
                    ->with('message' , "Sorry that page doesn't exist anymore.");
            }

        } else {
            return Redirect::route('home')
                ->with('message' , "Sorry you don't have rights to do that. Please login.");
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        if (Auth::check() === false) { // if NOT Authenticated

            return Redirect::route('pages.index')
                ->with('message' , "Sorry you don't have rights to do that. Please log in.");

        } else { // We are loged in as admin

        $valid = InfoPage::validate(Input::all());

        if ($valid->fails()) {
            return Redirect::route('pages.edit', $id)
                ->withErrors($valid)
                ->withInput();
        }

        $page = InfoPage::find($id);

        $page->name = Input::get('name');
        $page->content = Input::get('content');
        $page->contentHTML = Purifier::clean(Markdown::instance()->set_breaks_enabled(true)->parse(Input::get('content')));
        $page->order = Input::get('order');
        $page->visible =  true == Input::get('visible');

        $page->save();

        return Redirect::route('backend.page')
            ->with('message', 'Page ' . $page->name . ' was updated sucsessfuly');
        }

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        if (Auth::check() === false) { // if NOT Authenticated

            return Redirect::route('home')
                ->with('message' , "Sorry you don't have rights to do that. Please log in.");

        } else {
            $page = InfoPage::find($id);
            if ($page !== null) {
                $page->delete();
                return Redirect::route('backend.page')
                ->with('message', 'Page ' . $page->name . ' was deleted sucsessfuly');
            } else {
                return Redirect::route('backend.page')
                ->with('message', 'Page doesn\'t exist!');
            }
        }
    }

} // end of the object
