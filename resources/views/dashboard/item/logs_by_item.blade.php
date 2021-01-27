<?php

  $table_sessions = [
    Session::get('ITEM_LOGS_UPDATE_REMARKS_SUCCESS_ID'),
  ];

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
              <th>Action</th>
            </tr>
            @foreach($logs as $data) 
              <tr {!! __html::table_highlighter($data->id, $table_sessions) !!} >
                <td id="mid-vert">{{ $data->transaction_type == 1 ? 'Check In' : 'Check Out' }}</td>
                <td id="mid-vert">{!! $data->itemBatch ? $data->itemBatch->batch_code : 'NA' !!}</td>
                <td id="mid-vert">{!! $data->displayAmount() !!}</td>
                <td id="mid-vert">{!! Str::limit(strip_tags($data->remarks), 50) !!} ...</td>
                <td id="mid-vert">{{ optional($data->user)->username }}</td>
                <td id="mid-vert">{{ __dataType::date_parse($data->datetime, 'M d, Y g:i A') }}</td>
                <td id="mid-vert">
                  
                  @if(in_array('dashboard.item.logs_update_remarks', $global_user_submenus))
                    <a type="button" 
                       class="btn btn-default" 
                       id="update_remarks_button" 
                       data-remarks="{{ $data->remarks }}" 
                       data-url="{{ route('dashboard.item.logs_update_remarks', $data->id) }}">
                       Remarks
                    </a>
                  @endif

                </td>
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




@section('modals')

  <div class="modal fade" id="update_remarks_modal" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"> Remarks</h4>
        </div>
        <div class="modal-body" id="update_remarks_body">
          <form method="POST" id="form">
            
            @csrf
            
            <div class="row" style="padding-right:20px;">

              {!! 
                __form::textarea('12', 'remarks', 'Remarks', old('remarks'), $errors->has('remarks'), $errors->first('remarks'), '', '75') 
              !!}
              
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection




@section('scripts')

  <script type="text/javascript">

    @if(Session::has('ITEM_LOGS_UPDATE_REMARKS_SUCCESS'))
      {!! __js::toast(Session::get('ITEM_LOGS_UPDATE_REMARKS_SUCCESS')) !!}
    @endif
		
    $(document).on("click", "#update_remarks_button", function () {
      $("#update_remarks_modal").modal("show");
      $("#update_remarks_body #form").attr("action", $(this).data("url"));
      $("#form #remarks").val($(this).data("remarks"));
      $("#form #remarks").attr("placeholder", $(this).data("remarks"));
    });
    
  </script>

@endsection