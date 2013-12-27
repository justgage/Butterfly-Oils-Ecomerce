<?php

class CatController extends \BaseController {

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        //get only visible ones
        $cats = Cat::where('visible', '1')->get();
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
        $cats_raw = Cat::all();

        $cats;

        foreach ($cats_raw as $cat){
            $cats[$cat->id] = $cat->name;
        }

        //one for adding new categorys
        $cats['new'] = "--Create new Category--";

        if (Auth::check()) {
            return View::make('cats.create')
            ->with('title', 'Creating a new category')
            ->with('cats', $cats);
        } else {
            return Redirect::route('oils.index')
            ->with('message' , "Sorry you don't have rights to create a Category, please login");
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

        $valid_cat = Cat::validate(Input::all());

        if ($valid_cat->fails()) {
            return Redirect::route('cats.create')
            ->withErrors($valid_cat)
            ->withInput(); 
        }

        $cat = new Cat;
        $cat->name = Input::get('cat_name');
        $cat->urlName = Input::get('cat_urlName');
        $cat->info = Input::get('cat_info');
        $cat->visible = true;
        $cat->save();
        return Redirect::route('backend.index')
            ->with('message', 'Category ' . $cat->name . ' was created sucsessfuly');
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
        if (Auth::check()) {
            $cat = Cat::find($id);

            if ($cat !== null) {

                $oils = $cat->oils;
                $other = Cat::find(1);

                // reasign every category to "other"
                foreach ($oils as $oil){
                    $oil->cat()->associate($other);
                    $oil->save();
                }

                $cat->delete();
                return Redirect::route('backend.category')
                    ->with('message', 'Category "' . $cat->name . '" was deleted!, all Oils inside where moved to "Other"');
            } else {
                return Redirect::route('backend.category')
                    ->with('message', 'Category does not exist!' );
            }

        } else {
            return Redirect::route('oils.index')
            ->with('message' , "Sorry you don't have rights to create a Category, please login");
        }
    }

    public function missingMethod($array = array()) {
        return $array;
    }

}
