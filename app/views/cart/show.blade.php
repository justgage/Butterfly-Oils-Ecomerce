@extends('layout.main')

@section('content')
   <?php// var_dump($cart) ?>
   @foreach($cart as $item)
<div class="row">
   <div class="col-xs-3"> <em><a href="{{ URL::route('oils.show', $item['id']) }}">{{ $item['name'] }}</a></em> </div>
   <div class="col-xs-3"> ${{ $item['price'] }} </div>
   <div class="col-xs-3"> {{ $item['qty'] }} </div>
   <div class="col-xs-3"> ${{ $item['subtotal'] }} </div>
</div>
   @endforeach
<div class="row">
   <div class="col-md-12">
      <h3>TOTAL: ${{ $total }}</h3>
<a class="btn btn-warning" id="clear" href="#">Clear Cart</a>
   </div>
</div>
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

