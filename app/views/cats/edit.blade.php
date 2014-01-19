@extends('layout.main')

@section('content')

@include('includes.invalid', $errors)

{{ Form::model($cat, ["route" => array("cats.update", $cat->id), "method" => "put", 'class' => 'form-horizontal']) }}

<h1> Create a new Category </h1>

{{-- CAT DROP DOWN  --}}
<div>

    {{ Form::label('name', 'Category name') }}
    <p> {{ Form::text('name', null, ['placeholder' => 'Blends', 'id' => 'text_name', 'class' => 'form-control']) }} </p>

    {{ Form::label('info', 'Cat description') }}
    <p> {{ Form::textarea('info', null,
        ['placeholder' => 'small description of category', 'class' => 'form-control']) }} </p>

</div>

{{-- SUBMIT --}}
{{ Form::submit('Save', array('class' => 'btn-lg btn-primary pull-right')) }}
{{ Form::close() }}
@stop
