<!DOCTYPE html>
<html>
    <head>
        <title>{{ $title }} | ButterflyOils.com</title>
        <!-- Bootstrap -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
        <link href="/bootstrap/css/bootstrap.less.css" rel="stylesheet" media="screen">
        {{ HTML::style('css/main.css')}}
        @section('head')
        @show

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="../../assets/js/html5shiv.js"></script>
        <script src="../../assets/js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <div id="wrap">
            <div id="header">
                @include('layout.nav')
            </div>
    
    
            <div class="container">
                <div id="content">
                    <div class="clearfix"></div>
                    <form class="pull-right" action="{{ URL::route('search.show') }}" method="get">
                        <div class="form-group">
                            <input placeholder="Search..." type=search results=5 name=s class="form-control">
                        </div>
                    </form>
                    {{-- this will show the message if it exists --}}
                    @include('includes.message')
                    @section('content')
                    this is the main content
                    @show
                </div>
            </div>
        </div>

        <br>

            <div class="container text-right padding">
                <div class="credit">
                    @if( Auth::check() )
                        <a class="" href="{{ route('backend.index') }}">Backend</a>
                    @else
                        Backend <a class="" href=" {{ route('login')}} ">Login</a>
                    @endif
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
