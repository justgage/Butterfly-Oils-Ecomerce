@extends('layout.main')

@section('content')

@include('includes.invalid', $errors)

{{ Form::open(["route" => "oils.store", "method" => "post", "files" => true, 'class' => 'form-horizontal'])}}

<?php $col_size = "col-md-6"; ?>

<h1> Create new Oil </h1>
<div class="row">

   <div class="{{ $col_size }}">
   {{-- NAME --}}
      {{ Form::label('name', 'Name') }}
      <p> {{ Form::text('name', Input::old('name') , ['placeholder' => 'Spice Traders', 'class' => 'form-control']) }} </p>

   {{-- URL NAME --}}
      {{ Form::label('urlName', 'Name In url (no spaces)') }}
      <p> {{ Form::text('urlName', Input::old('urlName') , ['placeholder' => 'spice_traders', 'class' => 'form-control']) }} </p>



   {{-- PRICE --}}
      {{ Form::label('price', 'price') }}
      <div class="input-group">
          <span class="input-group-addon">$</span>
          {{ Form::text('price', Input::old('price') , 
               ['placeholder' => '10.00', 'class' => 'form-control']) }} 
      </div>
   
   {{-- COMPARE PRICE --}}
      {{ Form::label('compare_price', 'Compare Price (from compettitor)') }}
      <div class="input-group">
          <span class="input-group-addon">$</span>
          {{ Form::text('compare_price', Input::old('compare_price'),
                 [ 'placeholder' => '12.00', 'class' => 'form-control' ] ) }} 
     </div> 

   {{-- CAT DROP DOWN  --}}
    <h3> 
        {{ Form::label('cat_id', 'Category') }} 
        {{ Form::select('cat_id', $cats, null, ['id' => 'cat_select', 'class' => 'form-control']) }} 
    </h3>
    <div id="cat_new" style="display:none;">
        {{ Form::label('cat_name', 'Category name') }}
        <p> {{ Form::text('cat_name', Input::old('cat_name') , ['placeholder' => 'Blends', 'class' => 'form-control']) }} </p>

        {{ Form::label('cat_urlName', 'Category name in URL') }}
        <p> {{ Form::text('cat_urlName', Input::old('cat_urlName') , ['placeholder' => 'blends', 'class' => 'form-control']) }} </p>

        {{ Form::label('cat_info', 'Cat description') }}
        <p> {{ Form::textarea('cat_info', Input::old('cat_info'), 
                ['placeholder' => 'small description of category', 'class' => 'form-control']) }} </p>
           
    </div>
 </div>
   <div class="{{ $col_size }}">
   {{-- INFO --}}
      {{ Form::label('info', 'Oil Info') }}
      <p> {{ Form::textarea('info', Input::old('name'), ['placeholder' => 'This is what the oil is (uses, ingredints, etc..)', 'class' => 'form-control']) }} </p>
   

   
   {{-- IMAGE UPLOAD --}}
   {{ Form::label('image', 'Product_Images') }}
      <button type="button" class='upload_button btn btn-default pull-right'>Add more a photos</button>
      <p class="upload_input"> {{ Form::file('image[]') }} </p>
   
{{-- VISIBLE --}}
   <h4>
      Show in shop {{ Form::checkbox('visible', 'visible', ['checked' => Input::old('visible')] ) }} 
   </h4>
{{-- SUBMIT --}}
   {{ Form::submit('Save', array('class' => 'btn-lg btn-primary pull-right')) }}
   </div>

</div>
{{ Form::close() }}
@stop

@section('script')
<script type="text/javascript" charset="utf-8">
$( document ).ready(function () {

    // add another form for adding pictures
    $('.upload_button').click(function (e){
         console.log('click');
         e.preventDefault();
         var copy = $('.upload_input').first().clone();
         $(copy).insertBefore(this);
     });

    // show the category creation form when you select new
    var toggle_cat_create = function () {
        var value = $("#cat_select").val();

        if (value == 'new') {
            $('#cat_new').slideDown();
        } else {
            $('#cat_new').slideUp();
        }
    }

    toggle_cat_create();

    $('#cat_select').change(toggle_cat_create);

});
</script>
@stop
