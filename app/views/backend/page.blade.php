@extends('layout.main')

  
@section('content')
  <div class="pull-right">
      <a class="btn btn-warning" href="{{ URL::route('backend.logout')}}"> Logout </a> 
  </div>

  <?php $tab = 1; ?>
  @include('backend.include.nav')

<h2>Pages</h2>
<a href="{{ URL::route('pages.create')}}" class="btn btn-primary">
    + Add Page
</a>
<div class="panel panel-default">
    <table class="table">

        <thead>
            <tr>
                <th>Name</th>
                <th>hidden?</th>
                <th>content</th>
                <th>Delete / Edit</th>
            </tr>
        </thead>

        <tbody>
            @foreach($pages as $page) 
            @if ($page->visible == false) 
               <tr class="not-visible">
            @else
               <tr class="">
            @endif
                <td>
                    <strong> <a href="{{ URL::route('pages.show', ['urlName' => $page->urlName] ) }}">{{ $page->name }}</a> </strong>
                </td>
                @if ($page->visible == false)
                    <td><em> yes </em></td>
                @else
                    <td> no </td>
                @endif
                <td> {{ substr($page->content, 0, 400) }}...</td>
                <td>
                    {{ Form::open(array('route' => array('pages.destroy', $page->id), 'method' => 'delete')) }}
                    <button type="submit" href="{{ URL::route('pages.destroy', $page->id) }}" class="pull-left btn btn-danger btn-mini">
                        <span class="glyphicon glyphicon-trash"></span>
                        Delete
                    </button>
                    {{ Form::close() }}
                    <button class="btn btn-primary" href="#">Edit</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<a href="{{ URL::route('pages.create')}}" class="btn btn-primary">
    + Add Page
</a>


@stop
