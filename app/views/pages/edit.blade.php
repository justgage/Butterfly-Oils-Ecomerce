@extends('layout.main')


@section('content')
@include('includes.invalid', $errors)
{{ Form::model($page, array( "route" => array("pages.update", $id), 'method' => 'put', 'class' => 'form-horizontal' ))}}

<div class="row">
    <h1>Edit "{{ $page->name }}"</h1>

    {{-- NAME --}}
    <div class="form-group">
        {{ Form::label('name', 'Name', [ 'class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::text('name', null, [
                'autocomplete' => "off",
                'placeholder' => 'About Us',
                'id' => 'text_page_name',
                'class' => 'form-control'
            ]) }} 
        </div>
    </div>

    {{-- URL NAME --}}
    <div class="form-group">
        {{ Form::label('Order', 'Order number ', ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::text('order', null, [
                'placeholder' => '1',
                'class' => 'input-sm form-control'
            ]) }} 
            <span class="help-block">(higher is farther to the right)</span>
        </div>
    </div>

    {{-- CONTENT --}}
    {{ Form::label('content', 'Page Content (in Markdown)') }}
    <small>Markdown is a way of adding style to a page through keys on the keyboard <a href="{{ URL::route('backend.markdown') }}">Click here to learn more</a></small>
    <div class="panel panel-default">
        <div class="" id="epiceditor">
        {{ Form::textarea('content', null, [
            'placeholder' => 'This is the main content in markdown',
            'class' => 'form-control',
            'id' => 'epic-textarea',
            'style' => 'display:none;'
        ]) }} 
        </div>
    </div>



    {{-- VISIBLE --}}
    <h4 class="text-right">
        Show in Navigation {{ Form::checkbox('visible', 'visible') }} 
    </h4>
    
    {{ Form::submit('Save', array('class' => 'btn-lg btn-primary pull-right')) }}
</div>

{{ Form::close() }}

@stop

@section('script')
<script src="/js/EpicEditor/epiceditor/js/epiceditor.js"></script>
<script>
    var options = {
        textarea : 'epic-textarea',
        basePath : '{{ URL::to('/')}}/js/EpicEditor/epiceditor',
        clientSideStorage: false,
        autogrow : true,
        file : {
            defaultContent : "##Section Heading\n\nPage content goes here in __Markdown__\n\nPush the Eye to preview it.\n\nThe icon to the right of it to see it in fullscreen."
        }
    };

    var editor = new EpicEditor(options).load();
</script>
@stop
