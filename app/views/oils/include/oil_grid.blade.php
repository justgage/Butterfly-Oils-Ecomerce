<div class="row">
<?php $i = 0; ?>
@foreach ($oils as $oil)
    {{-- NOT error, has to be this way! --}}
<?php 
echo "<br><br>"; 
return 0;
?>
    @if ($oil->visible == true)  // ERROR property of non-object??
    <?php $i++ ?>

        <div class='col-sm-6 col-md-3' id='user_id_{{$oil->id}}'>
            @include('oils.include.oil_box', ['oil' => $oil])
        </div>

      {{-- clearfix for oils that are different sizes --}}
      @if($i % 4 === 0 )
         <div class="clearfix visible-md visible-lg"></div>
      @endif
      @if($i % 2 === 0 )
         <div class="clearfix visible-sm"></div>
      @endif

      <div class="clearfix visible-xs"></div>

  @endif
@endforeach

@if($i === 0)
    <h3>Sorry, there's no oils.</h3>
@endif
</div>
