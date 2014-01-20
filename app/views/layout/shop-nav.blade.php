            <br>
<ul class="nav nav-tabs">
    
    @if($tab === -1)
    <li class="active">
    @else
    <li>
    @endif
        <a class="nav bar" href="{{ URL::route('oils.index') }}">All</a>
    </li>
    {{-- Categories tabs --}}
    <?php $cats = Cat::all(); ?>

    @foreach($cats as $aCat)

        @if($tab === $aCat->id)
        <li class="active">
        @else
        <li>
        @endif

        @if($aCat->visible == true)
        <a href=" {{ route('cats.show', ["catId" => $aCat->urlName])}} ">
            {{ $aCat-> name}}
        </a>
        @endif
    </li>
    @endforeach
    
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

<br />
<div class="row">
    <div class="col-sm-4">
        <span>Name:</span>
        <a class="btn btn-default" href="{{ route('oils.index') . "?sort=name" }}"> A to Z</a>
        <a class="btn btn-default" href="{{ route('oils.index') . "?sort=name&reverse"}}">  Z to A</a>
    </div>
    
    <div class="col-sm-6">
        <span>Price:</span>
        <a class="btn btn-default" href="{{ route('oils.index') . "?sort=price" }}">Low to High</a>
        <a class="btn btn-default" href="{{ route('oils.index') . "?sort=price&reverse"}}">High to low</a>
    </div>
</div>
