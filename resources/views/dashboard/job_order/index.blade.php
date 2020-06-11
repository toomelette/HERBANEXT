<?php

  $table_sessions = [ Session::get('JOB_ORDER_CONFIRM_RFD_SUCCESS_SLUG') ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>





@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Job Orders</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.job_order.index') }}">

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.job_order.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('po_no', 'PO No.')</th>
            <th>@sortablelink('jo_no', 'JO No.')</th>
            <th>@sortablelink('item_product_code', 'Product Code')</th>
            <th>@sortablelink('item_name', 'Product Name')</th>
            <th style="width: 200px">Action</th>
          </tr>
          @foreach($job_orders as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ $data->po_no }}</td>
              <td id="mid-vert">{{ $data->jo_no }}</td>
              <td id="mid-vert">{{ $data->item_product_code }}</td>
              <td id="mid-vert">{{ $data->item_name }}</td>
              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.job_order.confirm_rfd', $global_user_submenus))
                    @if ($data->delivery_status == 0)
                      <a type="button" 
                         class="btn btn-danger btn-sm"  
                         id="confirm_rfd" 
                         data-action="confirm-rfd" 
                         data-url="{{ route('dashboard.job_order.confirm_rfd', ['check', $data->slug]) }}">
                         Not Ready for Delivery <i class="fa fa-times"></i>
                      </a>
                    @elseif($data->delivery_status == 1)
                      <a type="button" 
                         class="btn btn-success btn-sm"  
                         id="confirm_rfd" 
                         data-action="confirm-rfd" 
                         data-url="{{ route('dashboard.job_order.confirm_rfd', ['uncheck', $data->slug]) }}">
                         Ready for Delivery <i class="fa fa-check"></i>
                      </a>
                    @endif
                  @endif
                </div>
              </td>
            </tr>
            @endforeach
          </table>
      </div>

      @if($job_orders->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($job_orders) !!}
        {!! $job_orders->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

  <form id="frm-confirm-rfd" method="POST" style="display: none;">
    @csrf
  </form>

@endsection





@section('modals')

  {!! __html::modal_delete('job_order_delete') !!}

@endsection 





@section('scripts')

  <script type="text/javascript">

    $(document).on("click", "#confirm_rfd", function () {
      if($(this).data("action") == "confirm-rfd"){
        $("#frm-confirm-rfd").attr("action", $(this).data("url"));
        $("#frm-confirm-rfd").submit();
      }
    });
    
    @if(Session::has('JOB_ORDER_CONFIRM_RFD_SUCCESS'))
      {!! __js::toast(Session::get('JOB_ORDER_CONFIRM_RFD_SUCCESS')) !!}
    @endif

  </script>
    
@endsection