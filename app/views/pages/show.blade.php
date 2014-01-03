@extends('layout.main')

@section('content')
<h1>{{ $page->name }}</h1>

<div>
    {{ Markdown::instance()->set_breaks_enabled(true)->parse($page->content) }}
</div>
@stop
