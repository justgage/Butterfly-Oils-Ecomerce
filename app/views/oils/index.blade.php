@extends('layout.main')

@section('content')
@foreach ($oils as $oil)
<?php echo "<div id='user_id_$oil->id'>";  ?>
    <h3> <a href="{{ URL::route('oils.show', $oil->id) }}"> {{ $oil->name }} </a> </h3>
    <div class="oil_price"> ${{ $oil->price }}</div>
    <div class="oil_img"> *image here* </div>
    </div>
@endforeach
@stop

