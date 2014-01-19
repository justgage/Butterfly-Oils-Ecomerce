@extends('layout.main')

@section('content')
<h2>Payment Success!</h2>
<div class="row">
    <div class="col-md-7">
    <h3>Items</h3>
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
                <?php
                $item_del = 0;
                ?>
               @foreach($cart as $item)
                    <?php $oil = Oil::find($item['id']); ?>
                    @if($oil !== null)
                        <tr>                                                {{-- GET RID OF THIS CAT --}}
                           <td> <em><a href="{{ URL::route('oils.show', ["CAT" , Oil::find($item['id'])->urlName ]) }}">{{ $item['name'] }}</a></em> </td>
                           <td> ${{ $item['price'] }} </td>
                           <td> {{ $item['qty'] }} </td>
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
        
        <div class="text-right float-right">
            <h4>Total {{ $log->total }} </h4>
        </div>
    </div>
    
    
    <div class="col-md-5">
        <h3>Shipping to</h3>
        <div class="well">
            <p> {{{ $log->payer_first_name }}} {{{ $log->payer_last_name }}} </p>
            <p> {{{ $address['line1'] }}} </p>
            @if(isset($address['line2']))
                <p> {{{ $address['line1'] }}} </p>
            @endif
            <p>
                {{{ $address['city'] }}},
                {{{ $address['state'] }}} 
                {{{ $address['postal_code'] }}}
            </p>
             <p> {{{ $address['country_code'] }}} </p>
        </div>
    </div>

    <a class="btn btn-primary" href="javascript:window.print()"> <i class="glyphicon-print"></i>Print this</a>
</div>



@stop
