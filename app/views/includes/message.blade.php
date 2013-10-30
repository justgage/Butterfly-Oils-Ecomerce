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
<div class="alert alert-warning alert-dismisable">
 {{ $message }} 
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div>
@endif
