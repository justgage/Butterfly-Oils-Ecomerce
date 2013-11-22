<?php


class Oil extends Eloquent {

   protected $table = 'oils';
   protected $softDelete = true; // deletes are still stored in DB

   public function photos() {
      return $this->hasMany('Photo', 'oil_id');
   }

   public function cat() {
      return $this->belongsTo('Cat');
   }

   public function Tags()
   {
       return $this->belongsToMany('Tag');
   }
   

   public static $rules = array(
      "name" => "required|min:3|unique:oils,name",
      "urlName" => "required|alpha_dash|min:3|unique:oils,urlName",
      "info" => "required|min:4",
      "price" => "required|numeric|min:1",
      "compare_price" => "numeric",
      "image" => "image"
   );


   public static function validate($data) {
      return Validator::make($data, static::$rules);
   }
} 

?>
