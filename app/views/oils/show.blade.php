@extends('layout.main')

@section('head')  
   <!-- Magnific Popup core CSS file -->
   <link rel="stylesheet" href="/magnific-popup/magnific-popup.css"> 
@stop

@section('content')

   <div class="row">
      <div class="col-sm-7">
             <h1> <sup>{{ $oil->prefix }}</sup> {{ $oil->name }} </h1>
         <div class="well">
             <?php $saved = ($oil->compare_price - $oil->price) ; ?>

             @if ($oil->price < $oil->compare_price) 
                 <div class="comp-price">
                     <dd>
                         ${{ number_format($oil->compare_price,2) }}
                     </dd>
                     <dt>
                         Competitors price
                    </dt>
                 </div>
             @endif
    
             <div class="price">
                 <dd> ${{ number_format($oil->price, 2) }}
             </dd>
                 <dt>Price</dt>
             </div>

             <div>
                 <div class="oil-price text-center">
                     <button data-id="{{ $oil->id }}" class="cart_add btn btn-lg btn-success" >
                         <span class="cart_num" >Add to Cart</span> 
                         <span class="glyphicon glyphicon-shopping-cart"></span>
                     </button>
                 </div>
             </div>
         </div>
      
         <h2>Description</h2>
         <div> {{ $oil->info }}</div>

         <h2>Uses</h2>
             <div class="oil-uses">
                 @foreach($tags as $tag)
                 <a href=" {{ URL::route('tags.show', $tag->urlName) }} ">
                     {{ $tag->name }}
                 </a>
                 @endforeach
             </div>
             <div class="clearfix" ></div>
     </div>
       <div class="col-sm-offset-1 col-sm-3">
           <h2>Images</h2>
           @foreach($oil->photos as $photo)
           <a class="oil_show_photo_a" href="{{$photo->path}}">
               <img class="img-responsive oil_show_photo" src="{{ $photo->path }}" alt="photo"/></a>
           @endforeach
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

    @include('oils.include.cart_js');

@stop
