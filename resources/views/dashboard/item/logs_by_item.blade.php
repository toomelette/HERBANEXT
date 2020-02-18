<?php

  $table_sessions = [];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>





@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>List of Logs by Item</h1>
      <div class="pull-right" style="margin-top:-25px;">
        <a href="{{ route('dashboard.item.index') }}" type="button" class="btn btn-sm btn-default">
          <i class="fa fa-fw fa-arrow-left"></i> Back to List
        </a>
      </div>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.item.fetch_logs_by_item', $slug) }}">

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

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
            <th>@sortablelink('amount', 'Amount')</th>
            <th>@sortablelink('updated_at', 'Date')</th>
          </tr>
          @foreach($logs as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert"> {{ $data->transaction_type == 1 ? 'Check In' : 'Check Out' }}</td>
              <td id="mid-vert">
                @if(optional($data->item)->unit != 'PCS')
                  @if($data->transaction_type == 1)
                    <span class="text-green">{{ number_format($data->amount, 3) }} {{ $data->unit }}<span>
                  @else
                    <span class="text-red">{{ number_format($data->amount, 3) }} {{ $data->unit }}<span>
                  @endif
                @else
                  @if($data->transaction_type == 1)
                    <span class="text-green">{{ number_format($data->amount) }} {{ $data->unit }}<span>
                  @else
                    <span class="text-red">{{ number_format($data->amount) }} {{ $data->unit }}<span>
                  @endif
                @endif
              </td>
              <td id="mid-vert">{{ $data->created_at->diffForHumans() }}</td>
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

  </section>

@endsection