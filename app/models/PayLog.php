<?php

class PayLog extends Eloquent {

   protected $table = 'payLogs';

   //CHANGE ME! or delete me.
   public static $rules = array(
      "tag_name" => "required|unique:tags,name|min:2",
   );

   public static function validate($data) {
      return Validator::make($data, static::$rules);
   }
} 

?>
