<?php
//this is a way the check if we have a message
if (!isset($message)) {
   $message = Session::get('message');
   if (isset($message)) { 
      $message = Session::get('message'); 
   } 
   else { 
      $message = false; 
   }
} 
?>

@if($message !== false)
<div id="message"> {{ $message }} </div>
@endif
