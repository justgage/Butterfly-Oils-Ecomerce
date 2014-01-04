<?php

class Cat extends Eloquent {

   protected $table = 'cats';

   public function oils() {
      return $this->hasMany('Oil', 'cat_id');
   }

   public static $rules = array(
      "name" => "required|unique:cats,name|min:2",
      "info" => "required|min:12",
   );

   public static $rules_edit = array(
      "name" => "required",
      "info" => "required|min:12",
   );



   public static function validate($data) {
      return Validator::make($data, static::$rules);
   }

   public static function validate_edit($data) {
      return Validator::make($data, static::$rules_edit);
   }
} 

?>
