@extends('layout.main')

@section('content')
<h2>{{ $title }}</h2>

@include('oils.include.oil_grid', ["oils" => $oils])
@stop


@section('script')
@include('oils.include.cart_js');
@stop
