@extends('layout.main')

@section('content')
<h2>{{ $title }}</h2>

@include('oils.include.oil_grid', ["oils" => $oils])
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
