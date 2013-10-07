<!DOCTYPE html!>
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
Logged in as {{ Auth::user()->username }}
@else
<a href=" {{ route('login')}} ">Login</a>
@endif
            <hr />
        </div>
@if(isset($message))
        <div id="message">
          {{ $message }}
        </div>
@else
{{ $message = Session::get('message') }}
@endif

        
        <div id="content">
            @section('content')
                this is the main content
            @show
        </div>
    </body>
</html>
