<?php

class Cat extends Eloquent {

   protected $table = 'cats';

   public function oils() {
      return $this->hasMany('Oil', 'cat_id');
   }

   public static $rules = array(
      "cat_name" => "required|unique:cats,name|min:2",
      "cat_urlName" => "required|alpha_dash|min:3|unique:cats,urlName",
      "cat_info" => "required|min:12",
   );


   public static function validate($data) {
      return Validator::make($data, static::$rules);
   }
} 

?>
