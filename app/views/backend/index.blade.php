@extends('layout.main')
  
@section('content')
  This is a backend!
<a href="{{ URL::route('backend.logout')}}"> Logout </a> 
@stop
