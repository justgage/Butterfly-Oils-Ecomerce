@extends('layout.main')
  
@section('content')
  <div class="pull-right">
   <a class="btn btn-warning" href="{{ URL::route('backend.logout')}}"> Logout </a> 
  </div>
<div style="padding:0 20px" class="pull-right">
   <a href="{{ URL::route('oils.create')}}" class="btn btn-primary">Create New Oil</a>
</div>

<h2>Oils list</h2>
<table width="100%" cellspacing="0">
   <thead>
      <tr>
         <th>Name</th>
         <th>Description</th>
         <th>Price</th>
         <th>Compare Price</th>
         <th>Delete</th>
      </tr>
   </thead>
@foreach($oils as $oil)
<tbody>
   <tr>
      <td><a href="{{ URL::route('oils.show', $oil->id) }}"/>  {{ $oil->name  }}</a></td>
      <td>{{ $oil->info  }}</td>
      <td>{{ $oil->price  }}</td>
      <td>{{ $oil->compare_price  }}</td>
      <td><a href="{{URL::route('oils.destroy', $oil->id)}}">delete</a></td>
   </tr>
</tbody>


@endforeach
</table>


@stop
