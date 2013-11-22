@extends('layout.main')

@section('content')
<h1>Shopping Cart <span class="glyphicon glyphicon-shopping-cart"></span> </h1>
@if(empty($cart))

    <h3> No items in your cart! :( <a href="{{ URL::route('oils.index')}} ">Check out the Shop!</a> </h3>
    </div>

@else

<div class="col-md-12">
<table class="table table-hover table-striped">
<thead>
    <tr>
        <th>Remove</th>
        <th>Item</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
    </tr>
</thead>
   <tbody>
       @foreach($cart as $item)
        <tr>                                                {{-- GET RID OF THIS CAT --}}
            <td><a class="remove-item" data-id="{{ $item['rowid'] }}" href="#"><span class="glyphicon glyphicon-remove"></span> </a></td>
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
                   <h3>Total: ${{ number_format($total, 2) }} </h3>
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
    
    var count = {{ count($cart) }};

    $("#clear").click(function () {
        $.post("{{ URL::to('cart/clear') }}", {}, function (data) {
            console.log(data.mess);
            window.location.reload(true);
        });
    });

    $(".remove-item").click(function () {
        var url = "{{ URL::to('cart/remove') }}/" + $(this).data('id');
        var $that = $(this);

        $that.parent().parent().fadeOut(); // the table row

        var promise = $.get( url);

        promise.done(function (data) {
            console.log(data.mess);
            count--;

            if (count === 0) {
                window.location.reload(true);
            }
        });
        
        promise.fail(function () {
            //ERROR saying the AJAX failed!
            $that.parent().parent().fadeIn(); // the table row
        });

    });
});
</script>
@stop

