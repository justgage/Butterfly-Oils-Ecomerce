@extends('layout.main')
  
@section('content')
<h1> {{ $oil->name }} </h1>

<?php ?>
@foreach($oil->photos as $photo)
   <img class="oil_show_photo" src="{{ $photo->path }}" alt="photo"/>
@endforeach

<dt>Price</dt>
<dd> {{ $oil->price}}</dd>
<?php $saved = ($oil->compare_price - $oil->price) ; ?>

@if ($oil->price < $oil->compare_price) 
 <dt>Competitors price</dt>
 <dd> {{ $oil->compare_price}}</dd>
    <p> You save, ${{$saved}} or {{ round( ($oil->price / $oil->compare_price)  * 100 ) }}% </p>
@endif

<h2>Description</h2>
<div> {{ $oil->info}}</div>
@stop

