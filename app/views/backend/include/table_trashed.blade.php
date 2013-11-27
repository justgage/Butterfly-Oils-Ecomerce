@if( empty($oils->toArray) === false)

<a class="btn btn-default pull-right" href="{{ URL::route('oils.deleteAll'); }}">Empty Trash</a>
<table class="table table-striped table-hover" width="100%" cellspacing="0">
   <thead>
      <tr>
         <th>Visible</th>
         <th>Name</th>
         <th>Category</th>
         <th>Price</th>
         <th>Compare Price</th>
         <th>Delete</th>
      </tr>
   </thead>
<tbody class = "backend-table">
@foreach($oils as $oil)
    {{-- NOT error, has to be this way!  --}}
    @if ($oil->visible == true) 
       <tr class="">
    @else
       <tr class="not-visible">
    @endif
          <td>{{ ($oil->visible == true ? 'true' : 'false') }} </td>
          <td>  {{ $oil->name  }} </td>
          <td> <a href="{{ URL::route('cats.show', ['catId' => $oil->cat->urlName] );}}">
                    {{ $oil->cat->name}}
               </a>
          </td>
          <td>{{ $oil->price  }}</td>
          <td>{{ $oil->compare_price  }}</td>
          <td>
            <div class="btn-group">
            <a class="btn btn-info" href="{{ URL::route('oils.restore', $oil->id); }}">Restore</a>
            <a class="btn btn-danger" href="{{ URL::route('oils.delete', $oil->id); }}">Delete</a>
        </td>
       </tr>
@endforeach
</tbody>
</table>
<a class="btn btn-default pull-right" href="{{ URL::route('oils.deleteAll'); }}">Empty Trash</a>

@else
<p>
    Trash is empty
</p>
@endif
