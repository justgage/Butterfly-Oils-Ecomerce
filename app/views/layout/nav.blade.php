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

                <li><a class="nav bar" href="{{ URL::route('oils.index') }}">Shop</a></li>

                {{-- Categories drop down --}}
                <li id="category-DD" class="dropdown">
                    <a class="nav bar" data-toggle="dropdown" href="#">
                        By Categories <b class="caret">
                        </b></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                        <?php $cats = Cat::all(); ?>
                        @foreach($cats as $cat)
                        <li>
                            @if($cat->visible == true)
                            <a href=" {{ route('cats.show', ["catId" => $cat->urlName])}} ">
                                {{ $cat-> name}}
                            </a>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </li>

                {{-- Uses --}}
                <li id="category-DD" class="dropdown">
                    <a class="nav bar" data-toggle="dropdown" href="#">
                        By Uses <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                        <?php $tags = Tag::all(); ?>
                        
                        <li>
                            <a href="{{ route('shop.uses.index') }}"><b>View All</b></a>
                        </li>


                        @foreach($tags as $tag)
                        <li>
                            <a href=" {{ URL::route('tags.show', $tag->urlName) }} ">
                                {{ $tag-> name}}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>

            </ul>

            {{-- Everything on the right --}}
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{ URL::to('cart/show'); }}">
                        <span class="glyphicon glyphicon-shopping-cart"></span>
                        Shopping Cart (<span id="cart_total_count">{{ Cart::count() }}</span>)
                    </a>  
                </li>
                <li>
                    @if( Auth::check() )
                        <a href="{{ route('backend.index') }}">Backend</a>
                    @else
                        <a href=" {{ route('login')}} ">Login</a>
                    @endif
                </li>
            </ul>
        </div> 
    </div>
</div>
