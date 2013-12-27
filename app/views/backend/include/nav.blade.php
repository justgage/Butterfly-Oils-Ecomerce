<ul class="nav nav-tabs">

    <?php
    if (isset($tab) === false) {
        $tab = 0;
    }
    ?>

  @if($tab === 0)
      <li class="active">
  @else
      <li>
  @endif
      <a href="{{ URL::route('backend.index') }} ">Products</a>
  </li>

  @if($tab === 1)
      <li class="active">
  @else
      <li>
  @endif
      <a href="{{ URL::route('backend.category') }}">Categories</a>
  </li>

  @if($tab === 2)
      <li class="active">
  @else
      <li>
  @endif
      <a href="{{ URL::route('backend.logs') }}">Purchase logs</a>
  </li>

</ul>
