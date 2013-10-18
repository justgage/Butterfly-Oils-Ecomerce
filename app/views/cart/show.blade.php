@extends('layout.main')

@section('content')
   <?php var_dump($cart) ?>
   @foreach($cart as $item)
<div class="row">
   <div class="col-md-2"> <h4><a href="{{ URL::route('oils.show', $item['id']) }}">{{ $item['name'] }}</a></h3> </div>
   <div class="col-md-2"> ${{ $item['price'] }} </div>
   <div class="col-md-2"> {{ $item['qty'] }} </div>
   <div class="col-md-2"> ${{ $item['subtotal'] }} </div>
</div>
   @endforeach
<div class="row">
   <div class="col-md-12">
      <h3>TOTAL: ${{ $total }}</h3>
   </div>
</div>
@stop

