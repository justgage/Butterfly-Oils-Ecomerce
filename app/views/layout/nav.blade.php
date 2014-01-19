<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a id="butter-logo" class="navbar-brand" href="{{ route('home') }}"><img src="/img/butterfly.png" alt=""></a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                {{-- Three lines for mobile button --}}
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">

                <li>
                    <a class="nav bar" href="{{ URL::route('oils.index') }}">Shop</a>
                </li>


                <?php $pages = InfoPage::where('visible', '=', true)->orderBy('order')->get(); ?>
                @foreach($pages as $page)
                <li>
                    <a class="nav bar" href="{{ URL::route('pages.show', $page->urlName) }}">
                        {{ $page->name }}
                    </a>
                </li>
                @endforeach

            </ul>

            {{-- Everything on the right --}}
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{ URL::to('cart/show') }}">
                        <span class="glyphicon glyphicon-shopping-cart"></span>
                        Shopping Cart (<span id="cart_total_count">{{ Cart::count() }}</span>)
                    </a>  
                </li>
            </ul>
        </div> 
    </div>
</div>
