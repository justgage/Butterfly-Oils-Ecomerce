@extends('layout.main')
  
@section('content')
<h1> {{ $oil->name }} </h1>
<dt>Price</dt>
<dd> {{ $oil->price}}</dd>
<?php $saved = floor($oil->compare_price / $oil->price ); ?>

@if ($saved > 0) 
    <dt>Competitors price</dt>
    <dd> {{ $oil->compare_price}}</dd>
    <p> You save, $saved% </p>
@endif

<h2>Description</h2>
<div> {{ $oil->info}}</div>
@stop

