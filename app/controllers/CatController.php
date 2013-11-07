<?php

class CatController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $cats = Cat::all();
        return View::make('cats.index')
            ->with('title', "List of product categories")
            ->with('cats', $cats);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        if (Auth::check()) {
            return View::make('cats.create')
                ->with('title', 'Creating a new category');
        } else {
            return Redirect::route('oils.index')
                ->with('message' , "Sorry you don't have rights to create an oil, please login");
        }
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
       if (Auth::check() === false) { // if NOT Authenticated

          return Redirect::route('cats.index')
              ->with('message' , "Sorry you don't have rights to create a Category, please login"); 

      } else { // We are loged in as admin

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
        $cat = Cat::where('urlName', '=', $urlName)->first();

        $oils = $cat->oils;

        $v = View::make('cats.show');
        $v->title = $cat->name;
        $v->oils = $oils;
        $v->pretty_url = $this->pretty_url();

        return $v;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}