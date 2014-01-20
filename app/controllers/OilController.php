<?php


class OilController extends \BaseController {

    private function authReject() {
        return Redirect::route('oils.index')
        ->with('message' , "Sorry you don't have rights to create an oil, please login");
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $get = Input::all();
        $oils = Oil::where('visible', '=', true);
        $reverse = 'asc';

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

        $v = View::make('oils.index')->with('title', "Shop oils");
        $v->oils = $oils;
        $v->pretty_url = $this->pretty_url();

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

            return View::make('oils.create')
            ->with('title', 'Creating a new oil')
            ->with('cats', $cats);

        } else {
            return Redirect::route('home')
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
        if (Auth::check() === false) { 

            return Redirect::route('home')
            ->with('message' , "Sorry you don't have rights to create a product, please login"); 

        } else { // We are loged in as admin

        $valid = Oil::validate(Input::all());


        if ($valid->fails()) {

            return Redirect::route('oils.create')
            ->withErrors($valid)
            ->withInput(); 

        } else { // data IS valid

        // check if there's any with the same name
        $count = $count = Oil::where('name', '=', Input::get('name'))->count();

        if ($count != 0) {
            return Redirect::route('oils.create')
            ->with("message", "Oil name, " . Input::get('name') . " already exists." . $count )
            ->withInput(); 
        }


        $cat = Cat::find( (int) Input::get('cat_id') );

        $tags = explode(",", Input::Get('tags'));

        $tags_obj = $this->tags_arr_add($tags);

        // create oil in database
        $oil = new Oil;
        $oil->name          = Input::get('name');
        $oil->type          = Input::get('type');
        $oil->sciName       = Input::get('sciName');
        $oil->prefix        = Input::get('prefix');
        $oil->urlName       = $this->safeUrl(Input::get('name'));
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

        foreach ($tags_obj as $tag){
            $oil->tags()->attach($tag->id);
        }

        // Return message saying, it worked!
        return Redirect::route('backend.index')
        ->with('message', 'Product ' . $oil->name . ' was created sucsessfuly');;

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
            $tags = $oil->tags;
            $v = View::make('oils.show');
            $v->title = "oil " . $oil->name;
            $v->oil = $oil;
            $v->tags = $tags;
            return $v;

        } else {

            return View::make('oils.404')->with('title', 'Product not Found!');

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

            $oil = Oil::find($id);

            if($oil !== null) {
                $cats_raw = Cat::all();

                $cats;

                foreach ($cats_raw as $cat){
                    $cats[$cat->id] = $cat->name;
                }

                $tags_raw = $oil->tags;
                $tags = "";

                foreach ($tags_raw as $tag) {
                    $tags .= $tag->name . ",";
                }

                $tags = substr($tags, 0, -1);

                return View::make('oils.edit')
                ->with('title', 'Creating a new oil')
                ->with('cats', $cats)
                ->with('oil', $oil)
                ->with('tags', $tags);
            } else {
                return Redirect::route('backend.index')
                    ->with('message' , "Sorry that oil no longer exist to edit.");

            }

        } else {
            return Redirect::route('home')
                ->with('message' , "Sorry you don't have rights to create an oil, please login");
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
        if ( Auth::check() ) {

            $valid = Oil::validate(Input::all());

            $oil = Oil::find($id);

            if ($valid->fails()) {

                return Redirect::route('oils.edit', $id)
                    ->with($oil)
                    ->withErrors($valid)
                    ->withInput(); 

            } else {
                // IS VALID
                $check =  Oil::where('name', '=', Input::get('name'))->first();

                // no duplicate name
                if ( $check !== null && $check->id !== $id ) {
                    return Redirect::route('oils.edit', $id)
                    ->with("message", "Oil name, " . Input::get('name') . " already exists.")
                    ->withInput(); 
                }

                $cat = Cat::find( (int) Input::get('cat_id') );

                $tags = explode(",", Input::Get('tags'));

                $tags_obj = $this->tags_arr_add($tags);

                // update oil in database
                $oil->name          = Input::get('name');
                $oil->prefix        = Input::get('prefix');
                $oil->type          = Input::get('type');
                $oil->sciName       = Input::get('sciName');
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

                $tags_ids = [];
                foreach ($tags_obj as $tag){
                    $tags_ids[] = $tag->id;
                }

                $oil->tags()->sync($tags_ids);

                // Return message saying, it worked!
                return Redirect::route('backend.index')
                ->with('message', 'Product ' . $oil->name . ' was updated sucsessfuly');

            }

        } else {
            //Not autherized
            return Redirect::route('home')
            ->with('message' , "Sorry you don't have rights to create an oil, please login");
        }
    }

    /**
    * Soft delete product
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        if (Auth::check()) {
            $target = Oil::find($id);

            if ($target !== null) {
                $target->delete();
                return Redirect::back()->with('message', "The product " . $target->name . " was trashed" );
            } else {
                return Redirect::back()->with('message', "That product was already removed!" );
            }
        } else {
            return Redirect::route('home')
            ->with('message' , "Sorry you don't have rights to create an oil, please login");
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function delete($id)
    {
        if (Auth::check()) {
            $target = Oil::withTrashed()->where('id', $id)->first();

            if ($target !== null) {
                $target->forceDelete();
                return Redirect::back()->with('message', "The product " . $target->name . " was deleted forever" );
            } else {
                return Redirect::back()->with('message', "That product was already removed!" );
            }
        } else {
            return Redirect::route('home')
            ->with('message' , "Sorry you don't have rights to create an oil, please login");
        }
    }

    /**
    * Restore product
    *
    * @param  int  $id
    * @return Response
    */
    public function restore($id)
    {

        if (Auth::check()) {
            $target = Oil::withTrashed()->where('id', $id)->first();

            if ($target !== null) {
                $target->restore();
                return Redirect::back()->with('message', "The product " . $target->name . " was restored" );
            } else {
                return Redirect::back()->with('message', "That product was not in trash." );
            }

        } else {
            return Redirect::route('home')
            ->with('message' , "Sorry you don't have rights to create an oil, please login");
        }
    }

    public function deleteAll()
    {

        if (Auth::check()) {
            $targets = Oil::onlyTrashed()->get();

            if ($targets !== null) {
                foreach ($targets as $target){
                    $target->forceDelete();
                }
                return Redirect::back()->with('message', count($targets) . " products deleted" );
            } else {
                return Redirect::back()->with('message', "Trash was empty" );
            }

        } else {
            return $this->authReject();
        }
    }

}
