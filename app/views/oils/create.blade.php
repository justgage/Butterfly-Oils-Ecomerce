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
      <p> ${{ Form::text('price', Input::old('price') , ['placeholder' => '10.00', 'class' => 'form-control']) }} </p>
   </div>
   
   {{-- COMPARE PRICE --}}
   <div class="{{ $col_size }}">
      {{ Form::label('compare_price', 'Compare Price (from compettitor)') }}
      <p> ${{ Form::text('compare_price', Input::old('compare_price'), ['placeholder' => '12.00', 'class' => 'form-control'] ) }} </p>
   </div>
   
   {{ Form::label('image', 'Product_Images') }}
   @for ($i = 0; $i < 4; $i++)
   {{-- FILE UPLOAD --}}
   <div class="{{ $col_size }}">
      <p> {{ Form::file('image[]') }} </p>
   </div>
   @endfor
   
</div>
{{-- SUBMIT --}}
   {{ Form::submit('Add new oil', array('class' => 'btn-lg btn-primary')) }}
</div>
{{ Form::close() }}
@stop

