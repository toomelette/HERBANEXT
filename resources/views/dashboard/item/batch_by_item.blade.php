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

  <section class="content">

    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title" style="padding-top: 5px;">Batch by Item</h3>
          <div class="pull-right">
              <a href="{{ route('dashboard.item.index') }}" type="button" class="btn btn-sm btn-default">
                <i class="fa fa-fw fa-arrow-left"></i> Back to List
              </a>
          </div>
      </div>
      <div class="box-body no-padding" id="pjax-container">
  
        {{-- Form Start --}}
        <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.item.fetch_batch_by_item', $slug) }}">

          {{-- Table Search --}}        
          <div class="box-header with-border">
            {!! __html::table_search(route('dashboard.item.fetch_batch_by_item', $slug)) !!}
          </div>

        {{-- Form End --}}  
        </form>

        {{-- Table Grid --}}        
        <div class="box-body no-padding">
          <table class="table table-hover">
            <tr>
              <th>@sortablelink('batch_code', 'Batch Code')</th>
              <th>@sortablelink('amount', 'Amount')</th>
              <th>@sortablelink('expiry_date', 'Expiry Date')</th>
            </tr>
            @foreach($batches as $data) 
              <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
                <td id="mid-vert">{{ $data->batch_code }}</td>
                <td id="mid-vert">
                  @if($data->unit != 'PCS')
                    {{ number_format($data->amount, 3) }} {{ $data->unit }}
                  @else
                    {{ number_format($data->amount, 0) }} {{ $data->unit }}
                  @endif
                </td>
                <td id="mid-vert">
                  @if($data->expiry_date <= Carbon::now()->format('Y-m-d'))
                    <span class="text-red">{{ __dataType::date_parse($data->expiry_date, 'M d,Y') }}<span>
                  @else
                    {{ __dataType::date_parse($data->expiry_date, 'M d, Y') }}
                  @endif
                </td>
              </tr>
              @endforeach
            </table>
        </div>

        @if($batches->isEmpty())
          <div style="padding :5px;">
            <center><h4>No Records found!</h4></center>
          </div>
        @endif

      <div class="box-footer">
        {!! __html::table_counter($batches) !!}
        {!! $batches->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

      </div>

    </div>

  </section>

@endsection