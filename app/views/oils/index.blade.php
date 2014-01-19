@extends('layout.main')


@section('content')
<h1>Shop</h1>
@include('layout.shop-nav', ['tab' => -1])

@include('oils.include.oil_grid', ["oils" => $oils])
@stop


@section('script')
@include('oils.include.cart_js');
@stop
