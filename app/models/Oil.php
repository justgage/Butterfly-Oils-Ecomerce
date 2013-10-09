<?php


class Oil extends Eloquent {
   protected $table = 'oils';

   public function photos() {
      return $this->hasMany('Photo', 'oil_id');
   }

   public static $rules = array(
      "name" => "required|min:3",
      "info" => "required|min:10",
      "price" => "required|numeric|min:1",
      "compare_price" => "numeric",
      "image" => "image",
      "caption" => "required|min:3"
   );


   public static function validate($data) {
      return Validator::make($data, static::$rules);
   }
} 

?>
