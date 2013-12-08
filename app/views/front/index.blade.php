@extends('layout.main')

@section('content')
<div class="jumbotron">
<div class="container">
   <h1 class="text-center">Welcome to Butterfly Oils!</h1>
     <h2 class="text-center"> we're cool because...</h2>
   <ul>
     <li>We sell pure essential oils for cheeper than our competitors</li>
     <li>Easy to use website shopping experiance.</li>
     <li>PayPal powered for secure transactions</li>
   </ul>
   
   <a class="btn btn-primary btn-lg" href="{{ route('oils.index') }}">Go to the Shop »</a>
</div>
</div>

@stop
