@extends('layout.main')

@section('content')
<h1>Shopping Cart <span class="glyphicon glyphicon-shopping-cart"></span> </h1>
@if(empty($cart))

    <h3> No items in your cart! :( <a href="{{ URL::route('oils.index')}} ">Check out the Shop!</a> </h3>
    </div>

@else

<div class="panel panel-default">
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
        <?php
        $item_del = 0;
        ?>

       @foreach($cart as $item)
            <?php $oil = Oil::find($item['id']); ?>
            @if($oil !== null)
                <tr class="item">                                                {{-- GET RID OF THIS CAT --}}
                {{ Form::hidden('id', $item['rowid'], ['class' => 'row-id']) }}
                    <td><a class="remove-item" data-id="{{ $item['rowid'] }}" href="#"><span class="glyphicon glyphicon-remove"></span> </a></td>
                   <td> <em><a href="{{ URL::route('oils.show', ["CAT" , Oil::find($item['id'])->urlName ]) }}">{{ $item['name'] }}</a></em> </td>
                   <td> ${{ number_format($item['price'], 2) }} </td>
                   <td class="qty">
                       <button class="btn btn-default minus-qty">
                           <i class="glyphicon glyphicon-minus"></i>
                       </button> 
                       <input class="qty-feild form-control" name="qty[]" type="text" value="{{ $item['qty'] }}" /> 
                       <button class="btn btn-default add-qty">
                           <i class="glyphicon glyphicon-plus"></i>
                       </button> 
                   </td>
                   <td class="text-right"> <strong>${{ $item['subtotal'] }} </strong></td>
                </tr>
            @else 
                <?php 
                Cart::remove( $item['rowid'] ); 
                $item_del++;
                ?>
            @endif
       @endforeach
   </tbody>
@if($item_del > 0)
<em>{{ $item_del }} item(s) deleted due to them not being available in the shop anymore.</em>
@endif
</table>
</div>
   <div class="col-md-12">
       <div class="row">
           <div class="col-sm-12">
               <div class="text-right float-right">
{{ Form::submit("Update Cart", ["id" => "update", "class" => "btn btn-default"]) }}
<br />
                   shipping ${{ number_format(5.0, 2) }} 
                   <h4>Total $<span id="total">{{ number_format(Cart::total() + 5, 2) }}</span> </h4>
               </div>
           </div>
           <div class="col-sm-12">
               {{ HTML::link( URL::to('/paypal'), "Pay with PayPal", array("class" => "btn btn-primary pull-right"),true) }}
               <a class="btn btn-link pull-right" id="clear" href="#">Clear Cart</a>
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

    // Clear button

    $("#clear").click(function () {
        $.post("{{ URL::to('cart/clear') }}", {}, function (data) {
            console.log(data.mess);
            window.location.reload(true);
        });
    });

    // minus one
    $(".minus-qty").click(function (e) { 
        e.preventDefault();
        
        var $feild = $(this).parent().find("input");

        var val = $feild.val();

        if (val > 0 && --val !== NaN) {
            $feild.val(val);
        }
    });

    // add one
    $(".add-qty").click(function (e) { 
        e.preventDefault();
        
        var $feild = $(this).parent().find("input");

        var val = $feild.val();

        $feild.val(++val);
    });

    // update whole cart
    $("#update").click(function (e) {
        e.preventDefault();
        var url = "{{ URL::to('cart/update') }}"; 
        var data = [];
        $(".item").each(function () {
            $this = $(this);

            var item = {};

            item.id = $this.find(".row-id").first().val();
            item.qty = $this.find(".qty-feild").first().val();

            data.push(item);
        });

        var promise = $.post(url, { 'items' : data });

        promise.done(function (json) {
            if (json.worked === true) {
                window.location.reload(true);
            }
        });

        console.log(data);
        console.log(url);
    });

    $(".remove-item").click(function (e) {
        e.preventDefault();
        var url = "{{ URL::to('cart/remove') }}/" + $(this).data('id');
        var $that = $(this);

        $tr = $that.parent().parent();

        $tr.find("qty-feild").val(0);

        $tr.fadeOut().promise().done(function () {
            $(this).remove();
        }); // the table row

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

