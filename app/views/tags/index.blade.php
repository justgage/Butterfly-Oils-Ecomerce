@extends('layout.main')

@section('content')
<h2>{{ $title }}</h2>

<ul>
@foreach($tags as $tag)
<li>{{ $tag->name }}</li>
@endforeach
</ul>


@stop

