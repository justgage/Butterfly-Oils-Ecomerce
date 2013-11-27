@extends('layout.main')
  
@section('content')
  <div class="pull-right">
   <a href="{{ URL::route('oils.create')}}" class="btn btn-primary">+ Add Product</a>
   <a class="btn btn-warning" href="{{ URL::route('backend.logout')}}"> Logout </a> 
  </div>

<h2>Product list</h2>

<div class="panel panel-default">
    @include("backend.include.table", array("oils" => $oils) )
</div>

<div style="padding:0 20px" class="pull-right">
   <a href="{{ URL::route('oils.create')}}" class="btn btn-primary">+ Add Product</a>
</div>

<br />
<h3>Trash</h3>

<div class="well clearfix">
    @include("backend.include.table_trashed", array("oils" => Oil::onlyTrashed()->get()) )
</div>


@stop
