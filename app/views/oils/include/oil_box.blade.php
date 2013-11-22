{{-- Main Container --}}
<div class="oil_index_box" id="oil_id_{{ $oil->id }}">

    {{-- TITLE --}}
    <h3 class="text-center">
        <a href="{{ $pretty_url($oil->id) }}"> 
            {{ $oil->name }} 
        </a>
    </h3>

    <div class="well">
        {{-- IMAGE --}}
        <div class="oil_img"> 
            <a href="{{ $pretty_url($oil->id) }}"> 
                @if($oil->photos->isEmpty() === false)
                <img class="img-responsive" src="{{ $oil->photos->first()->path }}" alt="photo"/>
                @else
                <div class="img_empty img-responsive img-thumbnail"/>
                        <span class="glyphicon glyphicon-camera"></span>
                        No photos
                </div>
                @endif
                <p> More information </p>
            </a>
        </div>
    
        {{-- Price Button --}}
        <div class="oil_price">
            <div class="text-center">
                <h3>${{ number_format($oil->price, 2) }} </h3>
                    <button data-id="{{ $oil->id }}" class="cart_add btn btn-primary" >
                        <span class="cart_num" >Add to Cart</span> 
                        <span class="glyphicon glyphicon-shopping-cart"></span>
                    </button>
            </div>
        </div>
    </div>
</div>
