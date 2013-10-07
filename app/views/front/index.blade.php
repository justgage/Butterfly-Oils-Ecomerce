@extends('layout.main')

@section('content')
<h1>Welcome to Butterfly Oils!</h1>
  <h2> we're cool because </h2>
<ul>
  <li>We sell pure essential oils for cheeper than our competitors</li>
  <li>Easy to use website shopping experiance.</li>
  <li>PayPal powered for secure transactions</li>
</ul>

<a href="{{ route('oils.index') }}">Go to the Shop</a>
@stop

