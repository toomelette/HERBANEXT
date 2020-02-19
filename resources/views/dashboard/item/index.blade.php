<?php

  $table_sessions = [ Session::get('ITEM_UPDATE_SUCCESS_SLUG') ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>





@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Items</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.item.index') }}">

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.item.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('product_code', 'Product Code')</th>
            <th>@sortablelink('name', 'Name')</th>
            <th>@sortablelink('current_balance', 'Balance')</th>
            <th style="width: 400px">Action</th>
          </tr>
          @foreach($items as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ $data->product_code }}</td>
              <td id="mid-vert">{{ $data->name }}</td>
              <td id="mid-vert">
                  @if($data->min_req_qty > $data->current_balance)
                    @if($data->unit != 'PCS')
                      <span class="text-red">{{ number_format($data->current_balance, 3) }} {{ $data->unit }}<span>
                    @else
                      <span class="text-red">{{ number_format($data->current_balance) }} {{ $data->unit }}<span>
                    @endif
                  @else
                    @if($data->unit != 'PCS')
                      <span class="text-green">{{ number_format($data->current_balance, 3) }} {{ $data->unit }}<span>
                    @else
                      <span class="text-green">{{ number_format($data->current_balance) }} {{ $data->unit }}<span>
                    @endif
                  @endif
              </td>
              <td id="mid-vert">
                <div class="btn-group">
                  <a type="button" class="btn btn-default" id="checkin_button" href="{{ route('dashboard.item.check_in', $data->slug) }}">
                     Check-In
                  </a>
                  <a type="button" class="btn btn-default" id="checkin_button" href="{{ route('dashboard.item.check_out', $data->slug) }}">
                     Check-Out
                  </a>
                  <a type="button" class="btn btn-default" id="batch_button" href="{{ route('dashboard.item.fetch_batch_by_item', $data->slug) }}">
                    <i class="fa fa-cubes "></i>
                  </a>
                  <a type="button" class="btn btn-default" id="batch_button" href="{{ route('dashboard.item.fetch_logs_by_item', $data->slug) }}">
                    <i class="fa fa-file-text-o "></i>
                  </a>
                  <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.item.edit', $data->slug) }}">
                    <i class="fa fa-pencil"></i>
                  </a>
                  <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.item.destroy', $data->slug) }}">
                    <i class="fa fa-trash"></i>
                  </a>
                </div>
              </td>
            </tr>
            @endforeach
          </table>
      </div>

      @if($items->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($items) !!}
        {!! $items->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

@endsection





@section('modals')

  {!! __html::modal_delete('item_delete') !!} 

@endsection 





@section('scripts')

  <script type="text/javascript">

    {{-- CALL CONFIRM DELETE MODAL --}}
    {!! __js::button_modal_confirm_delete_caller('item_delete') !!}


    {{-- UPDATE TOAST --}}
    @if(Session::has('ITEM_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('ITEM_UPDATE_SUCCESS')) !!}
    @endif


    {{-- DELETE TOAST --}}
    @if(Session::has('ITEM_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('ITEM_DELETE_SUCCESS')) !!}
    @endif


  </script>
    
@endsection