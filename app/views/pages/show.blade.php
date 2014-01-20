@extends('layout.main')

@section('content')
<h1>{{{ $page->name }}}</h1>

<div>
    {{ $page->contentHTML }}
</div>
@stop
