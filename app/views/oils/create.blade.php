@extends('layout.main')

@section('content')

@include('includes.invalid', $errors)

{{ Form::open(["route" => "oils.store", "method" => "post", "files" => true])}}

<h1> Create new Oil </h1>
<div>
   {{ Form::label('name', 'Name') }}
   <p> {{ Form::text('name', Input::old('name') , ['placeholder' => 'Lavender']) }} </p>
</div>

<div>
   {{ Form::label('info', 'Oil Info') }}
   <p> {{ Form::textarea('info', Input::old('name'), ['placeholder' => 'This is what the oil is (uses, ingredints, etc..)']) }} </p>
</div>

<div>
   {{ Form::label('price', 'price') }}
   <p> ${{ Form::text('price', Input::old('price') , ['placeholder' => '10.00']) }} </p>
</div>

<div>
   {{ Form::label('compare_price', 'Compare Price (from compettitor)') }}
   <p> ${{ Form::text('compare_price', Input::old('compare_price'), ['placeholder' => '12.00'] ) }} </p>
</div>

<div>
   {{ Form::label('image', 'Product_Image') }}
   <p> {{ Form::file('image') }} </p>
</div>
<div>
   {{ Form::label('caption', 'Caption of Picture') }}
   <p> {{ Form::text('caption', Input::old('caption'), ['placeholder' => 'This is a photo of...'] ) }} </p>
</div>

<div>
   {{ Form::submit('Add new oil') }}
</div>
{{ Form::close() }}
@stop

