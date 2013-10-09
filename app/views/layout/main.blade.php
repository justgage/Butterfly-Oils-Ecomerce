<!DOCTYPE html>
<html>
<head>
  <title>{{ $title }} | ButterflyOils.com</title>
  {{ HTML::style('css/main.css')}}
</head>
<body>

<div id="header">
  <div id="logo">Butterfly Oils</div>
  <div id="nav"></div>
  <a href=" {{ route('oils.index')}} ">Shop</a>

  @if( Auth::check() )
    Logged in as <a href="{{ route('backend.index') }}">{{ Auth::user()->username }}</a>
  @else
    <a href=" {{ route('login')}} ">Login</a>
  @endif

  <hr />
</div>

{{-- this will show the message if it exists --}}
@include('includes.message')

<div id="content">
  @section('content')
  this is the main content
  @show
</div>
</body>
</html>
