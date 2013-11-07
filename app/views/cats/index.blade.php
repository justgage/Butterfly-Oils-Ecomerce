@extends('layout.main')

@section('content')
<h2>Product categories</h2>

<div class="row">
@foreach($cats as $cat)
    <div class="col-small-3"> 
    <h3>
        <a href="{{ URL::route("cats.show", [ $cat->urlName ]) }}" >
            {{$cat->name}}
        </a>
    </h3>
    <div> {{ $cat->info }} </div>

    </div> 
@endforeach
<div>
@stop
