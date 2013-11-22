@extends('layout.main')

@section('head')
<link rel="stylesheet" href="/js/tagsinput/bootstrap-tagsinput.css">
@stop


@section('content')

@include('includes.invalid', $errors)

{{ Form::open(["route" => "oils.store", "method" => "post", "files" => true, 'class' => 'form-horizontal'])}}

<?php $col_size = "col-md-6"; ?>

<h1> Create new Oil </h1>
<div class="row">
    <div class="{{ $col_size }}">

        {{-- NAME --}}
        <div class="form-group">
            {{ Form::label('name', 'Name', [ 'class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9">
                {{ Form::text('name', Input::old('name') , ['autocomplete' => "off", 'placeholder' => 'Spice Traders', 'id' => 'text_oil_name', 'class' => 'form-control']) }} 
            </div>
        </div>
    
       {{-- URL NAME --}}
        <div class="form-group">
              {{ Form::label('urlName', 'URL name', ['class' => 'col-sm-3 control-label']) }}
                <div class="col-sm-9">
                   {{ Form::text('urlName', Input::old('urlName') , 
                    ['placeholder' => 'spice_traders','id' => 'text_oil_urlName', 'class' => 'input-sm form-control']) }} 
                </div>
        </div>

       {{-- PRICE --}}
        <div class="form-group">
          {{ Form::label('price', 'price', ['class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9">
              <div class="input-group">
                  <span class="input-group-addon">$</span>
                  {{ Form::text('price', Input::old('price') , 
                       ['placeholder' => '10.00', 'class' => 'form-control']) }} 
                </div>
            </div>
        </div>
       
       {{-- COMPARE PRICE --}}
        <div class="form-group">
          {{ Form::label('compare_price', 'Compare Price', ['class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9">
                <div class="input-group">
                  <span class="input-group-addon">$</span>
                  {{ Form::text('compare_price', Input::old('compare_price'),
                         [ 'placeholder' => '12.00', 'class' => 'form-control' ] ) }} 
                </div> 
            </div> 
        </div>
    
        {{-- TAGS --}}
        <div class="form-group">
          {{ Form::label('tags', 'Uses tags', ['class' => 'col-sm-3 control-label']) }}
           <div class="input-group col-sm-9">
               {{ Form::text('tags', Input::old('tags') , 
                    ['class' => 'form-control', 'data-role' => 'tagsinput', 'placeholder' => '','id' => 'tags_input']) }} 
            <em>push enter to add a tag</em>
           </div>
        </div>
    
 </div>

   <div class="{{ $col_size }}">
       {{-- CAT DROP DOWN  --}}
        <h3> 
            {{ Form::label('cat_id', 'Category') }} 
            {{ Form::select('cat_id', $cats, null, ['id' => 'cat_select', 'class' => 'form-control']) }} 
        </h3>
        <div id="cat_new" style="display:none;">
            {{ Form::label('cat_name', 'Category name') }}
            <p> {{ Form::text('cat_name', Input::old('cat_name') , ['autocomplete' => "off", 'placeholder' => 'Blends', 'id' => 'text_cat_name', 'class' => 'form-control']) }} </p>
    
            {{ Form::label('cat_urlName', 'Category name in URL') }}
            <p> {{ Form::text('cat_urlName', Input::old('cat_urlName') , ['placeholder' => 'blends', 'id' => 'text_cat_urlName', 'class' => 'form-control']) }} </p>
    
            {{ Form::label('cat_info', 'Cat description') }}
            <p> {{ Form::textarea('cat_info', Input::old('cat_info'), 
                    ['placeholder' => 'small description of category', 'class' => 'form-control']) }} </p>
               
        </div>
   {{-- INFO --}}
      {{ Form::label('info', 'Oil Info') }}
      <p> {{ Form::textarea('info', Input::old('name'), 
                ['placeholder' => 'This is what the oil is (basic description, ingredints, etc..)',
                 'class' => 'form-control',
                 'rows' => 3
                ]) }} </p>
   
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
<script type="text/javascript" src="/js/tagsinput/bootstrap-tagsinput.js"></script>
<script type="text/javascript" src="/js/typeaheadjs/typeahead.js"></script>
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

    /***
     * Will take the input of one field
     * and put change it to a lowercase
     * and get rid of the spaces
     * then put into another feild (to)
     */
    var nameToUrlinput = function (to) {
        return function () {
            var text = $(this).val();
            text = text.toLowerCase(); // lowercase
            text = text.replace(/ *$/, ""); // get rid of white space at the end
            text = text.replace(/\s/g,"-"); // spaces to dash
            $(to).val(text);
        };
    };

    $("#text_oil_name").keyup(nameToUrlinput("#text_oil_urlName"));

    $("#text_cat_name").keyup(nameToUrlinput("#text_cat_urlName"));

    $('#cat_select').change(toggle_cat_create);


    // Adding custom typeahead support using http://twitter.github.io/typeahead.js
    $('#tags_input').tagsinput('input').typeahead({                                
          name: 'uses',                                                          
          prefech: "{{ URL::route('tags.ajax')}}",
          limit: 10                                                                   
      }).bind('typeahead:selected', $.proxy(function (obj, datum) {  
            console.log("clear");
            this.tagsinput('add', datum.value);
            var $input = this.tagsinput('input')
            $input.typeahead('setQuery', '');
            console.log($input.val());

          }, $('#tags_input')));;

});
</script>
@stop
