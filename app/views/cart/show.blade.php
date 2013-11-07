@extends('layout.main')

@section('content')
<h1> Shopping Cart </h1>
@if(empty($cart))
<div class="row">
<h3> No items in your cart! :( <a href="{{ URL::route('oils.index')}} ">Check out the Shop!</a> </h3>
</div>
@else
   @foreach($cart as $item)
    <div class="row">                                                {{-- GET RID OF THIS CAT --}}
       <div class="col-xs-3"> <em><a href="{{ URL::route('oils.show', ["CAT" , Oil::find($item['id'])->urlName ]) }}">{{ $item['name'] }}</a></em> </div>
       <div class="col-xs-3"> ${{ $item['price'] }} </div>
       <div class="col-xs-3"> {{ $item['qty'] }} </div>
       <div class="col-xs-3"> ${{ $item['subtotal'] }} </div>
    </div>
   @endforeach
   <div class="col-md-12">
       <div class="row">
           <div class="col-sm-12">
               <h3>TOTAL: <em>${{ number_format($total, 2) }}</em> </h3>
           </div>
           <div class="col-sm-12">
               {{ HTML::link( URL::to('/paypal'), "Checkout with PayPal", array("class" => "btn btn-primary pull-right"),true) }}
               <a class="btn btn-warning pull-right" id="clear" href="#">Clear Cart</a>
           </div>
       </div>
   </div>

@endif
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function () {
    $("#clear").click(function () {
        $.post("{{ URL::to('cart/clear') }}", {}, function (data) {
            console.log(data.mess);
            window.location.reload(true);
        });
    });
});
</script>
@stop

