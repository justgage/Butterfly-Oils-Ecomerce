<?php
class InfoPage extends Eloquent {

   protected $table = 'pages';

   public static $rules = array(
      "name" => "required|unique:cats,name|min:2",
      "urlName" => "required|alpha_dash|min:3|unique:cats,urlName",
      "content" => "required|min:12",
      "order" => "required|unique:pages,content",
   );


   public static function validate($data) {
      return Validator::make($data, static::$rules);
   }
} 

?>
