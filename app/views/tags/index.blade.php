@extends('layout.main')

@section('content')
<h2>{{ $title }}</h2>

<ul>
@foreach($tags as $tag)
<li>
    <a href="{{ URL::route('tags.show', $tag->urlName) }}">
        {{ $tag->name }}
    </a>
</li>
@endforeach
</ul>


@stop

