@if( count($oils->toArray()) > 0)
<table class="table table-striped table-hover" width="100%" cellspacing="0">
   <thead>
      <tr>
         <th>Visible</th>
         <th>Name</th>
         <th>Category</th>
         <th>Price</th>
         <th>Compare Price</th>
         <th>Trash</th>
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
          <td> <a href="{{ $pretty_url($oil->id) }}"/>  {{ $oil->name  }}</a></td>
          <td> <a href="{{ URL::route('cats.show', ['catId' => $oil->cat->urlName] );}}">
                    {{ $oil->cat->name}}
               </a>
          </td>
          <td>{{ $oil->price  }}</td>
          <td>{{ $oil->compare_price  }}</td>
          <td>
            {{ Form::open(array('route' => array('oils.destroy', $oil->id), 'method' => 'delete')) }}
            <button type="submit" href="{{ URL::route('oils.destroy', $oil->id) }}" class="btn btn-default btn-mini">
                <span class="glyphicon glyphicon-trash"></span>
                Trash
            </button>
            {{ Form::close() }}
        </td>
       </tr>
@endforeach
</tbody>
</table>


@else
<div class="panel-heading">There are no products.</div>
@endif
