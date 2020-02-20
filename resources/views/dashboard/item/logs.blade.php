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
    
  <section class="content-header">
      <h1>Item Logs</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.item.logs') }}">

      {!! __html::filter_open() !!}

        <div class="col-md-12">
          
          <h5>Date Filter : </h5>

          {!! __form::datepicker('3', 'df',  'From', old('df'), '', '') !!}

          {!! __form::datepicker('3', 'dt',  'To', old('dt'), '', '') !!}

          <button type="submit" class="btn btn-primary" style="margin:25px;">
            Filter Date <i class="fa fa-fw fa-arrow-circle-right"></i>
          </button>

        </div>

      {!! __html::filter_close('submit_dv_filter') !!}

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.item.logs')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('product_code', 'Product Code')</th>
            <th>@sortablelink('item.name', 'Name')</th>
            <th>@sortablelink('transaction_type', 'Transaction Type')</th>
            <th>@sortablelink('amount', 'Amount')</th>
            <th>@sortablelink('user.username', 'User Updated')</th>
            <th>@sortablelink('datetime', 'Date')</th>
          </tr>
          @foreach($logs as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ $data->product_code }}</td>
              <td id="mid-vert">
                @if(!empty($data->item))
                  {{ optional($data->item)->name }}
                @else
                  <span class="badge bg-red"><i class="fa fa-times "></i></span>
                @endif
                
              </td>
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

  </section>

@endsection