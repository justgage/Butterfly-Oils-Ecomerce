@extends('layout.main')

@section('head')  
   <!-- Magnific Popup core CSS file -->
   <link rel="stylesheet" href="/magnific-popup/magnific-popup.css"> 
@stop

@section('content')
   <h1> {{ $oil->name }} </h1>

   <div class="row">
         @foreach($oil->photos as $photo)
         <div class="col-md-3">
            <a class="oil_show_photo_a" href="{{$photo->path}}"><img class="responsive img-thumbnail oil_show_photo" src="{{ $photo->path }}" alt="photo"/></a>
         </div>
         @endforeach

      <div class="col-sm-12 col-md-3">
         <dt>Price</dt>
         <dd> {{ $oil->price}}</dd>
         <?php $saved = ($oil->compare_price - $oil->price) ; ?>
      
         @if ($oil->price < $oil->compare_price) 
          <dt>Competitors price</dt>
          <dd> {{ $oil->compare_price}}</dd>
             <p> You save, ${{$saved}} or {{ round( ($oil->price / $oil->compare_price)  * 100 ) }}% </p>
         @endif
      
         <h2>Description</h2>
         <div> {{ Markdown::transform($oil->info) }}</div>
      </div>
   </div>
@stop

@section('script')
   <!-- Magnific Popup core JS file -->
   <script src="/magnific-popup/jquery.magnific-popup.js"></script> 
   <script type="text/javascript" charset="utf-8">
   $(document).ready(function() {
      $('.oil_show_photo_a').magnificPopup({
         type:'image',
         gallery: {
          // options for gallery
          enabled: true
        },
      }
   );

   });
   </script>

@stop
