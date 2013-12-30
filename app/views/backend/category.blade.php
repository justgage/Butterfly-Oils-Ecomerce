@extends('layout.main')

  
@section('content')
  <div class="pull-right">
      <a class="btn btn-warning" href="{{ URL::route('backend.logout')}}"> Logout </a> 
  </div>
  @include('backend.include.nav')

<h2>Categories</h2>
<a href="{{ URL::route('cats.create')}}" class="">
    + Add Category
</a>
<div class="panel panel-default">
    <table class="table">

        <thead>
            <tr>
                <th>Name</th>
                <th>hidden?</th>
                <th>Description</th>
                <th>Oils in category</th>
                <th>Delete / Edit</th>
            </tr>
        </thead>

        <tbody>
            @foreach($cats as $cat) 
            @if ($cat->visible == false) 
               <tr class="not-visible">
            @else
               <tr class="">
            @endif
                <td>
                    <strong> <a href="{{ URL::route('cats.show', ['catId' => $cat->urlName] ) }}">{{ $cat->name }}</a> </strong>
                </td>
                @if ($cat->visible == false)
                    <td><em> yes </em></td>
                @else
                    <td> no </td>
                @endif
                <td> {{ $cat->info }}</td>
                <td>
                    {{ $cat->oils->count() }}
                </td>
                <td>
                    @if($cat->id != 1)
                        {{ Form::open(array('route' => array('cats.destroy', $cat->id), 'method' => 'delete')) }}
                        <button type="submit" href="{{ URL::route('cats.destroy', $cat->id) }}" class="pull-left btn btn-danger btn-mini">
                            <span class="glyphicon glyphicon-trash"></span>
                            Delete
                        </button>
                        {{ Form::close() }}
                    @endif
                    <button class="btn btn-primary" href="#">Edit</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<a href="{{ URL::route('cats.create')}}" class="btn btn-primary">
    + Add Category
</a>


@stop
