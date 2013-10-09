@if($errors->has())
<h3>Please Correct the following errors</h3>
  <ul style="color:red;">
@foreach ($errors->all() as $error)
   <li> {{ $error }}</li>
@endforeach
  </ul>
@endif
