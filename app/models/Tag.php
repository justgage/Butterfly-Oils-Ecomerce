<?php

class Tag extends Eloquent {

   protected $table = 'tags';

   public function oils() {
      return $this->belongsToMany('Oil');
   }

   public static $rules = array(
      "tag_name" => "required|unique:tags,name|min:2",
   );


   public static function validate($data) {
      return Validator::make($data, static::$rules);
   }
} 

?>
