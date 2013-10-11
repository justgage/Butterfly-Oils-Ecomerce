@extends('layout.main')

@section('content')
<h2> Essential Oil Products</h2>
<div class="row">
<?php $i = 0; ?>
@foreach ($oils as $oil)
<?php $i++;  ?>

   <?php echo "<div class='col-sm-6 col-md-3' id='user_id_$oil->id'>";  ?>
      <div class="oil_index_box" id="oil_id_{{ $oil->id }}">
         <h3> <a href="{{ URL::route('oils.show', $oil->id) }}"> {{ $oil->name }} </a> </h3>
         <div class="oil_img"> 
            <a href="{{ URL::route('oils.show', $oil->id) }}"> 
               <img class="img-responsive img-thumbnail" src="{{ $oil->photos->first()->path }}" alt="photo"/>
            </a>
         </div>
         <div class="oil_price">
            <h3 class="pull-right">${{ round($oil->price, 2) }} <button class="btn btn-default" >+ <span class="glyphicon glyphicon-shopping-cart"></span></button></h3>
            
         </div>
      </div>
   </div>
      @if($i % 4 === 0 )
         <div class="clearfix visible-md visible-lg"></div>
      @endif
      @if($i % 2 === 0 )
         <div class="clearfix visible-sm"></div>
      @endif
      <div class="clearfix visible-xs"></div>
@endforeach
@if($i === 0)
<h3>Sorry, there's no oils.</h3>
@endif
@stop

