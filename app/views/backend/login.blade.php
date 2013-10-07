@extends('layout.main')
  
@section('content')
  {{ Form::open(array('route' => array('backend.check', 'autocomplete' => 'off' ))) }}
  <p>
    {{ Form::label('username', "Username") }}
    {{ Form::text('username', "", [ "placeholder" => "username" ])}}
  <p>
  </p>
    {{ Form::label('password', "Password") }}
    {{ Form::password('password', [ "placeholder" => "••••••••••" ])}}
  </p>
  {{ Form::submit("Login") }}
  {{ Form::close() }}
@stop


