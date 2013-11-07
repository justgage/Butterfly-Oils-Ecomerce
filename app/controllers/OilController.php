<?php

class OilController extends \BaseController {



    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        /**
         * HELPER
         * easy way to get the SEO friendly URL
         */
        $pretty_url = function ($id) {
            $oil = Oil::find($id);
            return URL::route('oils.show', ["cat", $oil->urlName]);
        };

        $oils = Oil::orderBy('name')->get();

        $v = View::make('oils.index')->with('title', "Shop oils");
        $v->oils = $oils;
        $v->pretty_url = $pretty_url;
        
        return $v;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (Auth::check()) {
            $cats_raw = Cat::all();

            $cats;

            foreach ($cats_raw as $cat){
                $cats[$cat->id] = $cat->name;
            }

            //one for adding new categorys
            $cats['new'] = "--Create new Category--";

            return View::make('oils.create')
                ->with('title', 'Creating a new oil')
                ->with('cats', $cats);
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

            return Redirect::route('oils.index')
                ->with('message' , "Sorry you don't have rights to create an oil, please login"); 

        } else { // We are loged in as admin

            $valid = Oil::validate(Input::all());

            if ($valid->fails()) {

                return Redirect::route('oils.create')
                    ->withErrors($valid)
                    ->withInput(); 

            } else { // data IS valid

                // check if there's any with the same name
                $count = $count = Oil::where('name', '=',
                    Input::get('name'))->count();

                if ($count != 0) {
                    return Redirect::route('oils.create')
                        ->with("message", "Oil name, " . Input::get('name') . " already exists." . $count )
                        ->withInput();; 
                }

                // add a category if select new
                if (Input::get('cat_id') === 'new') {
                    $cat = new Cat;
                    $cat->name = Input::get('cat_name');
                    $cat->urlName = Input::get('cat_urlName');
                    $cat->info = Input::get('cat_info');
                    $cat->visible = true;
                    $cat->save();
                } 

                $cat = Cat::find( (int) Input::get('cat_id') );


                // create oil in database
                $oil = new Oil;
                $oil->name          = Input::get('name');
                $oil->urlName       = Input::get('urlName');
                $oil->compare_price = Input::get('compare_price');
                $oil->info          = Input::get('info');
                $oil->price         = Input::get('price');
                $oil->visible       = ('visible' == Input::get('visible')) ; // hack for checkbox
                $oil->cat()->associate($cat);

                $oil->save();

                // save the image(s) assosiated with it. 
                $files = Input::file('image');

                foreach($files as $file) {
                    if ($file !== null) {

                        $photo = new Photo;

                        $ext = $file->getClientOriginalExtension();
                        $filename = str_random(40) . ".$ext";
                        $file->move('public/uploads', $filename);

                        $photo->path = '/uploads/' . $filename;

                        $photo = $oil->photos()->save($photo);
                    }

                }

                // Return message saying, it worked!
                return Redirect::route('backend.index')
                    ->with('message', 'Oil ' . $oil->name . ' was created sucsessfuly');;

            } // if valid
        } // if auth
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($cat, $urlName)
    {

        $oil = Oil::where('urlName', '=', $urlName)->first();

        if  ($oil !== NULL) {
            $v = View::make('oils.show');
            $v->title = "oil " . $oil->name;
            $v->oil = $oil;
            return $v;

        } else {

            return View::make('oils.404')->with('title', 'Oil not Found!');

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
        $target = Oil::find($id);

        if ($target !== null) {
            $target->delete();
            return Redirect::back()->with('message', "The oil " . $target->name . " was removed" );
        } else {
            return Redirect::back()->with('message', "That oil was already removed!" );
        }



    }

}
