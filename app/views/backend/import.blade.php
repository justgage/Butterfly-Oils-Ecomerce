@extends('layout.main')

  
@section('content')
    @include('backend.include.nav')
<h1>Compare with ButterflyExpress.com</h1>

<?php
$curl = curl_init(); 
curl_setopt($curl, CURLOPT_URL, 'http://butterflyexpress.net/shopping');  
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);  
url_close($curl);  

$html = curl_exec($curl);  
$html = str_get_html();

$table = $html->find('div[class=shop_sect]',0);

$rows = $table->find('tr[class=row_dark]');


?>




@stop

@section('script')
<script>
$( document ).ready(function () {
    var html;

    console.log($(html).find("table"));

});
</script>
@stop
