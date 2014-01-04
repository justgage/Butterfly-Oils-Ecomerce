@extends('layout.main')

@section('content')

@include('includes.invalid', $errors)

{{ Form::open(["route" => "cats.store", "method" => "post", 'class' => 'form-horizontal']) }}

<h1> Create a new Category </h1>

{{-- CAT DROP DOWN  --}}
<div>

    {{ Form::label('name', 'Category name') }}
    <p> {{ Form::text('name',  Input::old('name') , ['autocomplete' => "off", 'placeholder' => 'Blends',  'class' => 'form-control']) }} </p>

    {{ Form::label('info', 'Cat description') }}
    <p> {{ Form::textarea('info',  Input::old('info'), 
    ['placeholder' => 'small description of category', 'class' => 'form-control']) }} </p>

</div>

{{-- SUBMIT --}}
{{ Form::submit('Save', array('class' => 'btn-lg btn-primary pull-right')) }}
{{ Form::close() }}
@stop

