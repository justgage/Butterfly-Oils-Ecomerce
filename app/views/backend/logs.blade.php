@extends('layout.main')

  
@section('content')
  <div class="pull-right">
      <a class="btn btn-warning" href="{{ URL::route('backend.logout')}}"> Logout </a> 
  </div>
  <?php $tab = 3; ?>
  @include('backend.include.nav')

<h2>Purchase Logs</h2>

<?php
function pretty_date($date) {
    $return_str = "";
    $today = \Carbon\Carbon::now();
    $week_ago = $today->copy()->subWeek();

    if( $date->isToday() ) {
        return $date->diffForHumans( $today );
    } else if ($date > $week_ago) {
        return "Last " . $date->format('l jS \\of F');
    } else {
        return $date->toFormattedDateString() . " (" . $date->diffForHumans( $today ) . ")";
    }
}
?>

{{ $month_total }}

<table class="table table-striped table-condensed table-hover" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>id</th>
            <th>state</th>
            <th>Date Created</th>
            <th>Buyer Name</th>
            <th>Buyer Email</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
        @if($log->total == false)
        <tr class="danger">
        @else
        <tr>
        @endif
            <td>{{ $log->id }}</td>
            <td>{{ $log->state }}</td>
            <td>{{ pretty_date($log->created_at) }}</td>
            <td>{{ $log->payer_first_name ? $log->payer_first_name . " " . $log->payer_last_name : "---" }}</td>
            <td>{{ $log->payer_email }}</td>
            <td>{{ $log->total ? "$".number_format($log->total,2) : "---" }}</td>
        </tr>
        @endforeach
    </tbody>

</table>

@stop
