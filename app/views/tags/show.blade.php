@extends('layout.main')

@section('content')
<h2>{{ $title }}</h2>

<ul>
{{ var_dump($tag->oils()->first()) }}
@foreach($tag->oils() as $oil)
<li>
    {{ $oil->name }}
</li>
@endforeach
</ul>


@stop

