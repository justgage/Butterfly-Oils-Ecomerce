@extends('layout.main')

@section('content')

<h2>{{ $title }}</h2>

@if($tags->isEmpty() && $oils->isEmpty() && $pages->isEmpty() )
    <em>Sorry! "{{{ $term }}}" was not found! please try another search.</em>

@else
    {{-- Tags (Uses) --}}

    @if($tags->isEmpty() === false)
        <h2> Uses </h2>
        <p>Find oils by their uses</p>
        <ul>
        @foreach($tags as $tag)
            <li>
                <a href=" {{ URL::route('tags.show', $tag->urlName) }} ">
                    {{{ $tag->name }}}
                </a>
            </li>
        @endforeach
        </ul>
    @endif


    @if($oils->isEmpty() === false)
    <h2> In Oils...  </h2>

    {{-- Oils --}}
    <div class="row">
        @foreach($oils as $oil)
        {{-- title --}}
        <h3>
            <a href="{{ $pretty_url($oil->id) }}"> 
                <sup>{{ $oil->prefix }}</sup>{{ $oil->name }} 
            </a>
            <small>
                {{{ $oil->type  }}}
            </small>
        </h3>

            {{-- image --}}
            <div class="col-sm-3"> 
                <a href="{{ $pretty_url($oil->id) }}"> 
                    @if($oil->photos->isEmpty() === false)
                    <img class="img-responsive" src="{{ $oil->photos->first()->path }}" alt="photo"/>
                    @else
                    <div class="img_empty img-responsive img-thumbnail"/>
                        <span class="glyphicon glyphicon-camera"></span>
                        No photos
                    </div>
                    @endif
                </a>
            </div>

            <div class="col-sm-9">

                <p>
                {{ nl2br(substr($oil->info, 0, 500)) }}...  <a href="{{ $pretty_url($oil->id) }}"> [more] </a>
                </p>

                {{-- price --}}
                <div class="oil_price">
                    <div class="clearfix">
                        <h4 class="pull-left pad">${{ number_format($oil->price, 2) }} </h4>
                        <button data-id="{{ $oil->id }}" class="cart_add btn btn-primary pull-left" >
                            <span class="cart_num" >Add to Cart</span> 
                            <span class="glyphicon glyphicon-shopping-cart"></span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="clearfix"> </div>

        @endforeach
    </div>
    @endif

    @if($pages->isEmpty() === false)
    <h2> In Pages...  </h2>

    @foreach($pages as $page)

    <a class="nav bar" href="{{ URL::route('pages.show', $page->urlName) }}">
        <h3>
            {{ $page->name }}
        </h3>
        
    </a>

        
    @endforeach

    @endif


@endif

@stop
