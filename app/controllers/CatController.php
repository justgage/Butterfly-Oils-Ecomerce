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
        if (Auth::check()) {
            return View::make('cats.create')
            ->with('title', 'Creating a new category');
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
    public function store() {
        if (Auth::check() === false) {

            return Redirect::route('cats.index')->with('message' , "Sorry you don't have rights to create a Category, please login");

        } else {

            $valid_cat = Cat::validate(Input::all());

            if ($valid_cat->fails()) {
                return Redirect::route('cats.create')
                ->withErrors($valid_cat)
                ->withInput(); 
            }

            $cat = new Cat;

            $cat->name = Input::get('name');
            $cat->urlName = $this->safeUrl( Input::get('name') );
            $cat->info = Input::get('info');
            $cat->visible = true;
            $cat->save();

            return Redirect::route('backend.category')->with('message', 'Category ' . $cat->name . ' was updated successfully');
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

        $oils = Oil::where('visible', '=', true)->where('cat_id', '=', $cat->id);

        $reverse = 'asc';
        $get = Input::all();

        if ( isset($get['sort']) ) {

           if ( isset($get['reverse']) ) {
               $reverse = 'desc';
           }

           if ($get['sort'] == "name") {
               $oils->OrderBy('name', $reverse);

           } elseif ($get['sort'] == "price") {
               $oils->OrderBy('price', $reverse);
           }

        } 

        $oils =  $oils->get();

        $v = View::make('cats.show');
        $v->title = $cat->name;
        $v->cat = $cat;
        $v->oils = $oils;
        $v->pretty_url = $this->pretty_url();
        $v->baseurl = route('cats.show', $urlName);

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
        if (Auth::check() === false) {
            return Redirect::route('home')->with('message' , "Sorry you don't have rights to do that");

        } else { // We are loged in as admin
            $cat = Cat::find($id);

            if ($cat !== null) {
                return View::make('cats.edit')
                    ->with('title', 'Editing a new category')
                    ->with('cat', $cat);
            } else {
                return Redirect::route('backend.category')->with('message' , "That Category no longer exists!");
            }
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
        if (Auth::check() === false) {

            return Redirect::route('backend.login')->with('message' , "Sorry you don't have rights to create a Category, please login");

        } else {

            $valid_cat = Cat::validate_edit(Input::all());

            if ($valid_cat->fails()) {
                return Redirect::route('cats.edit')
                ->withErrors($valid_cat)
                ->withInput(); 
            }

            $cat = Cat::find($id);

            if ($cat === null) {
                return Redirect::route('cats.edit')->with('message', "This id doesnt work $id")
                ->withInput(); 
            }

            $cat->name = Input::get('name');
            $cat->info = Input::get('info');
            $cat->visible = true;

            $cat->save();

            return Redirect::route('backend.index')
            ->with('message', 'Category ' . $cat->name . ' was updated successfully');
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
