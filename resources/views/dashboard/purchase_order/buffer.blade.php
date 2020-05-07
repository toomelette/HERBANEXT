<?php

  $table_sessions = [ Session::get('PURCHASE_ORDER_UPDATE_SUCCESS_SLUG') ];

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
      <h1>For Buffer Purchase Orders</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.purchase_order.buffer') }}">

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
        {!! __html::table_search(route('dashboard.purchase_order.buffer')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('po_no', 'PO No.')</th>
            <th>@sortablelink('bill_to_name', 'Bill to')</th>
            <th>@sortablelink('ship_to_name', 'Ship to')</th>
            <th>@sortablelink('created_at', 'Date')</th>
            <th style="width: 250px">Action</th>
          </tr>
          @foreach($purchase_orders as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ $data->po_no }}</td>
              <td id="mid-vert">
                <b>{{ $data->bill_to_name }}</b><br>
                {{ $data->bill_to_company }}<br>
                {{ $data->bill_to_address }}<br>
              </td>
              <td id="mid-vert">
                <b>{{ $data->ship_to_name }}</b><br>
                {{ $data->ship_to_company }}<br>
                {{ $data->ship_to_address }}<br>
              </td>
              <td id="mid-vert">{{ __dataType::date_parse($data->created_at, 'M d, Y g:i A') }}</td>

              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.purchase_order.to_process', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="process_button" data-action="process" data-url="{{ route('dashboard.purchase_order.to_process', $data->slug) }}">
                      Process &nbsp;<i class="fa fa-plus"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.purchase_order.show', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="show_button" href="{{ route('dashboard.purchase_order.show', $data->slug) }}">
                      <i class="fa fa-print"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.purchase_order.edit', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.purchase_order.edit', $data->slug) }}">
                      <i class="fa fa-pencil"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.purchase_order.destroy', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.purchase_order.destroy', $data->slug) }}">
                      <i class="fa fa-trash"></i>
                    </a>
                  @endif
                </div>
              </td>

            </tr>
            @endforeach
          </table>
      </div>

      @if($purchase_orders->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($purchase_orders) !!}
        {!! $purchase_orders->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

  <form id="frm-process" method="POST" style="display: none;">
    @csrf
  </form>

  <form id="frm-delivery" method="POST" style="display: none;">
    @csrf
  </form>

@endsection





@section('modals')

  {!! __html::modal_delete('po_delete') !!}

  {{-- DV CREATE SUCCESS --}}
  @if(Session::has('PURCHASE_ORDER_UPDATE_SUCCESS'))

    {!! __html::modal_print(
      'po_update', '<i class="fa fa-fw fa-check"></i> Updated!', Session::get('PURCHASE_ORDER_UPDATE_SUCCESS'), route('dashboard.purchase_order.show', Session::get('PURCHASE_ORDER_UPDATE_SUCCESS_SLUG'))
    ) !!}

  @endif

@endsection 





@section('scripts')

  <script type="text/javascript">

    $(document).on("click", "#process_button", function () {
      if($(this).data("action") == "process"){
        $("#frm-process").attr("action", $(this).data("url"));
        $("#frm-process").submit();
      }
    });

    $(document).on("click", "#delivery_button", function () {
      if($(this).data("action") == "delivery"){
        $("#frm-delivery").attr("action", $(this).data("url"));
        $("#frm-delivery").submit();
      }
    });

    {{-- CALL CONFIRM DELETE MODAL --}}
    {!! __js::button_modal_confirm_delete_caller('po_delete') !!}

    {{-- UPDATE Modal --}}
    @if(Session::has('PURCHASE_ORDER_UPDATE_SUCCESS'))
      $('#po_update').modal('show');
    @endif

    {{-- DELETE TOAST --}}
    @if(Session::has('PURCHASE_ORDER_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('PURCHASE_ORDER_DELETE_SUCCESS')) !!}
    @endif

    {{-- BUFFER PROCESS TOAST --}}
    @if(Session::has('PURCHASE_ORDER_TO_UPDATE_TYPE_SUCCESS'))
      {!! __js::toast(Session::get('PURCHASE_ORDER_TO_UPDATE_TYPE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection