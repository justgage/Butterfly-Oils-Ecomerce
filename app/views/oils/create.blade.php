@extends('layout.main')

@section('content')

@include('includes.invalid', $errors)

{{ Form::open(["route" => "oils.store", "method" => "post", "files" => true, 'class' => '.form-horizontal'])}}

<?php $col_size = "col-md-6"; ?>

<h1> Create new Oil </h1>
<div class="row">
   {{-- NAME --}}
   <div class="{{ $col_size }}">
      {{ Form::label('name', 'Name') }}
      <p> {{ Form::text('name', Input::old('name') , ['placeholder' => 'Lavender', 'class' => 'form-control']) }} </p>
   
   {{-- INFO --}}
      {{ Form::label('name', 'Name') }}
      {{ Form::label('info', 'Oil Info') }}
      <p> {{ Form::textarea('info', Input::old('name'), ['placeholder' => 'This is what the oil is (uses, ingredints, etc..)', 'class' => 'form-control']) }} </p>
   </div>
   
   {{-- PRICE --}}
   <div class="{{ $col_size }}">
      {{ Form::label('price', 'price') }}
      <p> ${{ Form::text('price', Input::old('price') , 
               ['placeholder' => '10.00', 'class' => 'form-control']) }} </p>
   </div>
   
   {{-- COMPARE PRICE --}}
   <div class="{{ $col_size }}">
      {{ Form::label('compare_price', 'Compare Price (from compettitor)') }}
      <p> ${{ Form::text('compare_price', Input::old('compare_price'),
             [ 'placeholder' => '12.00', 'class' => 'form-control' ] ) }} </p> 
   </div>
   
   {{-- IMAGE UPLOAD --}}
   {{ Form::label('image', 'Product_Images') }}
   <div class="{{ $col_size }}">
      <p class="upload_input"> {{ Form::file('image[]') }} </p>
      <button type="button" class='upload_button btn btn-primary'>Add a file</button>
   </div>
   
</div>
{{-- VISIBLE --}}
   <p>
      Visible to users? {{ Form::checkbox('visible', 'visible', Input::old('visible') ) }} 
   </p>
{{-- SUBMIT --}}
   {{ Form::submit('Add new oil', array('class' => 'btn-lg btn-primary')) }}
</div>
{{ Form::close() }}
@stop

@section('script')
<script type="text/javascript" charset="utf-8">
$( document ).ready(function () {
      $('.upload_button').click(function(e){
         console.log('click');
         e.preventDefault();
         var copy = $('.upload_input').first().clone();
         $(copy).insertBefore(this);
         });
      });
</script>
@stop
