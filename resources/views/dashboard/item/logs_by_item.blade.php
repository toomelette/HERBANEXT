<?php

  $table_sessions = [];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),

                        'df' => Request::get('df'),
                        'dt' => Request::get('dt'),
                      ];

?>





@extends('layouts.admin-master')

@section('content')

  <section class="content">

    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title" style="padding-top: 5px;">Logs by Item</h3>
          <div class="pull-right">
            &nbsp;
            {!! __html::back_button(['dashboard.item.index', 'dashboard.item.check_in', 'dashboard.item.check_out']) !!}          
          </div>
      </div>
      <div class="box-body no-padding" id="pjax-container">
    
        {{-- Form Start --}}
        <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.item.fetch_logs_by_item', $slug) }}">

          {{-- Table Search --}}        
          <div class="box-header with-border">
            {!! __html::table_search(route('dashboard.item.fetch_logs_by_item', $slug )) !!}
          </div>

        {{-- Form End --}}  
        </form>

        {{-- Table Grid --}}        
        <div class="box-body no-padding">
          <table class="table table-hover">
            <tr>
              <th>@sortablelink('transaction_type', 'Transaction Type')</th>
              <th>@sortablelink('itemBatch.batch_code', 'Batch Code')</th>
              <th>@sortablelink('amount', 'Quantity')</th>
              <th>@sortablelink('remarks', 'Remarks')</th>
              <th>@sortablelink('user.name', 'User Updated')</th>
              <th>@sortablelink('datetime', 'Date')</th>
            </tr>
            @foreach($logs as $data) 
              <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
                <td id="mid-vert">{{ $data->transaction_type == 1 ? 'Check In' : 'Check Out' }}</td>
                <td id="mid-vert">{!! $data->itemBatch ? $data->itemBatch->batch_code : 'NA' !!}</td>
                <td id="mid-vert">{!! $data->displayAmount() !!}</td>
                <td id="mid-vert">{{ $data->remarks }}</td>
                <td id="mid-vert">{{ optional($data->user)->username }}</td>
                <td id="mid-vert">{{ __dataType::date_parse($data->datetime, 'M d, Y g:i A') }}</td>
              </tr>
              @endforeach
            </table>
        </div>

        @if($logs->isEmpty())
          <div style="padding :5px;">
            <center><h4>No Records found!</h4></center>
          </div>
        @endif

        <div class="box-footer">
          {!! __html::table_counter($logs) !!}
          {!! $logs->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
        </div>

    </div>
  </div>

  </section>

@endsection