@extends('layout.main')

@section('content')

@include('includes.invalid', $errors)

{{ Form::open(["route" => "oils.store", "method" => "post", "files" => true])}}

<h1> Create new Oil </h1>
{{-- NAME --}}
<div>
   {{ Form::label('name', 'Name') }}
   <p> {{ Form::text('name', Input::old('name') , ['placeholder' => 'Lavender']) }} </p>
</div>

{{-- INFO --}}
<div>
   {{ Form::label('info', 'Oil Info') }}
   <p> {{ Form::textarea('info', Input::old('name'), ['placeholder' => 'This is what the oil is (uses, ingredints, etc..)']) }} </p>
</div>

{{-- PRICE --}}
<div>
   {{ Form::label('price', 'price') }}
   <p> ${{ Form::text('price', Input::old('price') , ['placeholder' => '10.00']) }} </p>
</div>

{{-- COMPARE PRICE --}}
<div>
   {{ Form::label('compare_price', 'Compare Price (from compettitor)') }}
   <p> ${{ Form::text('compare_price', Input::old('compare_price'), ['placeholder' => '12.00'] ) }} </p>
</div>

{{ Form::label('image', 'Product_Images') }}
@for ($i = 0; $i < 4; $i++)
{{-- FILE UPLOAD --}}
<div>
   <p> {{ Form::file('image[]') }} </p>
</div>
@endfor

{{-- SUBMIT --}}
<div>
   {{ Form::submit('Add new oil') }}
</div>
{{ Form::close() }}
@stop

