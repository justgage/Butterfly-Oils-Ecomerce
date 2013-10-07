<!DOCTYPE html!>
<html>
    <head>
        <title>{{ $title }} | ButterflyOils.com</title>
    </head>
    <body>
        <div id="header">
            <div id="logo">Butterfly Oils</div>
            <div id="nav"></div>
<a href=" {{ route('oils.index')}} ">Shop</a>
<a href=" {{ route('login')}} ">Login</a>
            <hr />
        </div>
@if(isset($message))
        <div id="message">
          {{ $message }}
        </div>
@else
{{ $message =  Session::get('message') }}
@endif

        
        <div id="content">
            @section('content')
                this is the main content
            @show
        </div>
    </body>
</html>
