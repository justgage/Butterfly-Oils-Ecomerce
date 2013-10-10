<?php

class OilController extends \BaseController {

   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function index()
   {
      $v = View::make('oils.index')->with('title', "Shop oils");
      $v->oils = Oil::orderBy('name')->get();
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
         return View::make('oils.create')->with('title', 'Creating a new oil');
      } else {
         return Redirect::route('oils.index')->with('message' , "Sorry you don't have rights to create an oil, please login");
      }
   }

   /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
   public function store()
   {
      if (Auth::check()) {
         $valid = Oil::validate(Input::all());
         //return var_dump(Input::all());
         if ($valid->fails()) 
         { return Redirect::route('oils.create')->withErrors($valid)->withInput(); } 
         else 
         {
            $count = $count = Oil::where('name', '=', Input::get('name'))->count();
            if ($count != 0) {
               return Redirect::route('oils.create')
                  ->with("message", "Oil name, " . Input::get('name') . " already exists." . $count )
                  ->withInput();; 
            }

            // if (Input::hasFile('image') === false) {
            //    return Redirect::route('oils.create')
            //       ->with("message", "File failed to upload")
            //       ->withInput();; 
            // } 

            $oil = new Oil;

            //create oil
            $oil->name = Input::get('name');
            $oil->info = Input::get('info');
            $oil->price = Input::get('price');
            $oil->compare_price = Input::get('compare_price');
            $oil->name = Input::get('name');

            $oil->save();

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
            return Redirect::route('oils.index')->with('message', 'Oil ' . $oil->name . ' was created sucsessfuly');;
         }

      } else { return Redirect::route('oils.index')->with('message' , "Sorry you don't have rights to create an oil, please login"); }
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function show($id)
   {
      $oil = Oil::find($id);

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
      //
   }

}
