@extends('layout.main')

@section('content')

<h2>{{ $title }}</h2>

<p>Find products by what they are used for.</p>

@if( empty($tags) === true)
    <h4>Sorry, no tags where found!</h4>
@else
    <ul>
    @foreach($tags as $tag)
        <?php $count = $tag->oils()->count(); ?>
        @if($count > 0)
            <li>
                <a href=" {{ URL::route('tags.show', $tag->urlName) }} ">
                    {{ $tag->name }} ({{ $tag->oils()->count() }})
                </a>
            </li>
        @endif
    @endforeach
    </ul>
@endif


@stop

