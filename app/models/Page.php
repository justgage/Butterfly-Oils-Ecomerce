<?php
class InfoPage extends Eloquent {

   protected $table = 'pages';

   public static $rules = array(
      "name" => "required|unique:cats,name|min:2",
      "content" => "required|min:12",
      "order" => "required|unique:pages,content",
   );


   public static function validate($data) {
      return Validator::make($data, static::$rules);
   }
} 

?>
