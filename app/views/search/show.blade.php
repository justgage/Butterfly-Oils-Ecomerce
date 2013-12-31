@extends('layout.main')

@section('content')

<h2>{{ $title }}</h2>

@if($tags->isEmpty() && $oils->isEmpty() )
    <em>Sorry! "{{{ $term }}}" was not found! please try another search.</em>

@else
    {{-- Tags (Uses) --}}

    @if($tags->isEmpty() === false)
        <h2>
            In Tags...
        </h2*(>
        <ul>
        @foreach($tags as $tag)
            <li>
                <a href=" {{ URL::route('tags.show', $tag->urlName) }} ">
                    {{ $tag->name }} 
                </a>
            </li>
        @endforeach
        </ul>
    @endif


    @if($oils->isEmpty() === false)
        <h2>
            In Oils...
        </h2>

        @foreach($oils as $oil)
        {{-- Oils --}}
        <div class="clearfix">

            {{-- title --}}
            <h3>
                <a href="{{ $pretty_url($oil->id) }}"> 
                    {{ $oil->name }} 
                </a>
            </h3>

            {{-- image --}}
            <div class="pull-left"> 
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

            <blockquote>{{ $oil->info }}</blockquote>

            {{-- price --}}
            <div class="oil_price">
                <div class="clearfix">
                    <button data-id="{{ $oil->id }}" class="cart_add btn btn-primary pull-left" >
                        <span class="cart_num" >Add to Cart</span> 
                        <span class="glyphicon glyphicon-shopping-cart"></span>
                    </button>
                    <h4 class="pull-left">${{ number_format($oil->price, 2) }} </h4>
                </div>
            </div>
        </div>

        @endforeach
    @endif

@endif

@stop
