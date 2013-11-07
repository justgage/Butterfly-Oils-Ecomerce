@extends('layout.main')

@section('content')
<h2> All of our products</h2>
<div class="row">
<?php $i = 0; ?>
@foreach ($oils as $oil)

    {{-- NOT error, has to be this way! --}}
    @if ($oil->visible == true) 
    <?php $i++;  ?>

       <div class='col-sm-6 col-md-3' id='user_id_{{$oil->id}}'>
          <div class="oil_index_box" id="oil_id_{{ $oil->id }}">
             <h3> <a href="{{ $pretty_url($oil->id) }}"> {{ $oil->name }} </a> </h3>
             <div class="oil_img"> 
                <a href="{{ $pretty_url($oil->id) }}"> 
    @if($oil->photos->isEmpty() === false)
                   <img class="img-responsive img-thumbnail" src="{{ $oil->photos->first()->path }}" alt="photo"/>
    @else
                   <img class="img_empty img-responsive img-thumbnail" src="" alt="There is no photo"/>
    @endif
<p> Click here for more Information </p>
                </a>
             </div>
             <div class="oil_price">
                <h3 class="pull-right">${{ round($oil->price, 2) }} 
                <button data-id="{{ $oil->id }}" class="cart_add btn btn-primary" >
                <span class="cart_num" >Add to Cart</span> 
                <span class="glyphicon glyphicon-shopping-cart"></span></button></h3>
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
    @endif
@endforeach
@if($i === 0)
<h3>Sorry, there's no oils.</h3>
@endif
@stop


@section('script')

<script type="text/javascript">
var laravel_URL = "{{ URL::to('cart/add') }}"; // NOTE: blade templating
var cart = {{ Cart::content()->toJSON() }};
$( document ).ready(function () {
    for( item in cart ) {
        var id =  cart[item].id;
        $("#oil_id_" + id ).find('.cart_num').
            html(cart[item].qty + " x in cart");
        $("#oil_id_" + id ).find('.cart_add').removeClass("btn-primary").addClass("btn-default");

    }

    $(".cart_add").click(function() {
          var id = $(this).attr("data-id");
          var me = this;
          $.post(laravel_URL, {id : id}, function (data) {
             console.log(data.mess);
             console.log(data);
             $(me).find(".cart_num").html(data.qty + " x in cart");
             $(me).removeClass("btn-primary").addClass("btn-default");
             $("#cart_total_count").html(data.count);

             }, "json");
          });
});
</script>
@stop
