<!DOCTYPE html>
<html>
<head>
  <title>{{ $title }} | ButterflyOils.com</title>
  {{ HTML::style('css/main.css')}}
  <!-- Bootstrap -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    @section('head')
    @show

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div id="header">
<div class="navbar navbar-inverse navbar-fixed-top">
<div class="container">
   <div class="navbar-header">
      <a class="navbar-brand" href="{{ route('home') }}">ButterflyOils.com</a>
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
   </div>
   <div class="collapse navbar-collapse">
     <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
           <li>
              <a href=" {{ route('oils.index')}} ">Shop</a>
           </li>
   
        </ul>
   <ul class="nav navbar-nav navbar-right">
      <li>
         @if( Auth::check() )
         <a href="{{ route('backend.index') }}">Logged in as {{ Auth::user()->username }}</a>
         @else
         <a href=" {{ route('login')}} ">Login</a>
         @endif
      </li>
   </ul>
     </div>
   </div>
</div>

</div>


<div class="container">
<div id="content">
{{-- this will show the message if it exists --}}
@include('includes.message')
  @section('content')
  this is the main content
  @show
</div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bootstrap/js/bootstrap.min.js"></script>
@section('script')
@show
</body>
</html>
