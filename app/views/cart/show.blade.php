@extends('layout.main')

@section('content')
<h1> Shopping Cart </h1>
@if(empty($cart))

    <h3> No items in your cart! :( <a href="{{ URL::route('oils.index')}} ">Check out the Shop!</a> </h3>
    </div>

@else

<div class="col-md-12">
<table class="table table-hover table-striped">
<thead>
    <tr>
        <th>Item</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
    </tr>
</thead>
   <tbody>
       @foreach($cart as $item)
        <tr>                                                {{-- GET RID OF THIS CAT --}}
           <td> <em><a href="{{ URL::route('oils.show', ["CAT" , Oil::find($item['id'])->urlName ]) }}">{{ $item['name'] }}</a></em> </td>
           <td> ${{ $item['price'] }} </td>
           <td> {{ $item['qty'] }} </td>
           <td class="text-right"> <strong>${{ $item['subtotal'] }} </strong></td>
        </tr>
       @endforeach
   </tbody>
</table>
   <div class="col-md-12">
       <div class="row">
           <div class="col-sm-12">
               <div class="text-right float-right">
                   <h3>TOTAL: <em>${{ number_format($total, 2) }}</em> </h3>
               </div>
           </div>
           <div class="col-sm-12">
               {{ HTML::link( URL::to('/paypal'), "Checkout with PayPal", array("class" => "btn btn-primary pull-right"),true) }}
               <a class="btn btn-warning pull-right" id="clear" href="#">Clear Cart</a>
           </div>
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

