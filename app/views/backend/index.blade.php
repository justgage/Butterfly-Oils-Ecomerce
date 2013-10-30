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
         <th>Visible</th>
         <th>Name</th>
         <th>Description</th>
         <th>Price</th>
         <th>Compare Price</th>
         <th>Delete</th>
      </tr>
   </thead>
<tbody class = "backend-table">
@foreach($oils as $oil)
    @if ($oil->visible == true)
       <tr class="">
    @else
       <tr class="not-visible">
    @endif
          <td>{{  ($oil->visible == true ? 'true' : 'false') }}</td>
          <td><a href="{{ URL::route('oils.show', $oil->id) }}"/>  {{ $oil->name  }}</a></td>
          <td>{{ $oil->info  }}</td>
          <td>{{ $oil->price  }}</td>
          <td>{{ $oil->compare_price  }}</td>
          <td>
            {{ Form::open(array('route' => array('oils.destroy', $oil->id), 'method' => 'delete')) }}
            <button type="submit" href="{{ URL::route('oils.destroy', $oil->id) }}" class="btn btn-danger btn-mini">Delete</button>
            {{ Form::close() }}
        </td>
       </tr>
@endforeach
</tbody>
</table>


@stop
