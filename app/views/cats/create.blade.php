@extends('layout.main')

@section('content')

@include('includes.invalid', $errors)

{{ Form::open(["route" => "cats.store", "method" => "post", 'class' => 'form-horizontal']) }}

<h1> Create a new Category </h1>

{{-- CAT DROP DOWN  --}}
<div>
    {{ Form::label('cat_name', 'Category name') }}
    <p> {{ Form::text('cat_name', Input::old('cat_name') , ['autocomplete' => "off", 'placeholder' => 'Blends', 'id' => 'text_cat_name', 'class' => 'form-control']) }} </p>

    {{ Form::label('cat_urlName', 'Category name in URL') }}
    <p> {{ Form::text('cat_urlName', Input::old('cat_urlName') , ['placeholder' => 'blends', 'id' => 'text_cat_urlName', 'class' => 'form-control']) }} </p>

    {{ Form::label('cat_info', 'Cat description') }}
    <p> {{ Form::textarea('cat_info', Input::old('cat_info'), 
    ['placeholder' => 'small description of category', 'class' => 'form-control']) }} </p>

</div>

{{-- SUBMIT --}}
{{ Form::submit('Save', array('class' => 'btn-lg btn-primary pull-right')) }}
{{ Form::close() }}
@stop

@section('script')
<script>
$( document ).ready(function () {
        /***
         * Will take the input of one field
         * and put change it to a lowercase
         * and get rid of the spaces
         * then put into another feild (to)
         */
        var nameToUrlinput = function (to) {
            return function () {
                var text = $(this).val();
                text = text.toLowerCase(); // lowercase
                text = text.replace(/ *$/, ""); // get rid of white space at the end
                text = text.replace(/\s/g,"-"); // spaces to dash
                $(to).val(text);
            };
        };
    
        $("#text_cat_name").keyup(nameToUrlinput("#text_cat_urlName"));
});
</script>
@stop
