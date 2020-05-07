<?php

  $table_sessions = [ Session::get('DELIVERY_UPDATE_SUCCESS_SLUG') ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>

@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Delivery List</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.delivery.index') }}">

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.delivery.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('delivery_code', 'Delivery Code')</th>
            <th>@sortablelink('description', 'Description')</th>
            <th>@sortablelink('date', 'Delivery Date')</th>
            <th>@sortablelink('', 'Delivery Status')</th>
            <th>@sortablelink('updated_at', 'Last Updated')</th>
            <th style="width:300px;:">Action</th>
          </tr>
          @foreach($deliveries as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} > 
              <td id="mid-vert">{{ $data->delivery_code }}</td>
              <td id="mid-vert">{{ $data->description }}</td>
              <td id="mid-vert">{{ __dataType::date_parse($data->date, 'F d, Y') }}</td>
              <td id="mid-vert">{!! $data->displayDeliveryStatus() !!}</td>

              <td id="mid-vert">{{ $data->updated_at->diffForHumans() }}</td>
              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.delivery.confirm_delivery', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.delivery.confirm_delivery', $data->slug) }}">
                      Delivery Items
                    </a>
                  @endif
                  @if(in_array('dashboard.delivery.show', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.delivery.show', $data->slug) }}">
                      <i class="fa fa-print"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.delivery.edit', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.delivery.edit', $data->slug) }}">
                      <i class="fa fa-pencil"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.delivery.destroy', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.delivery.destroy', $data->slug) }}">
                      <i class="fa fa-trash"></i>
                    </a>
                  @endif
                </div>
              </tr>
            @endforeach
          </table>
      </div>

      @if($deliveries->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($deliveries) !!}
        {!! $deliveries->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

@endsection





@section('modals')

  {!! __html::modal_delete('delivery_delete') !!}

@endsection 





@section('scripts')

  <script type="text/javascript">

    {{-- CALL CONFIRM DELETE MODAL --}}
    {!! __js::button_modal_confirm_delete_caller('delivery_delete') !!}

    {{-- UPDATE TOAST --}}
    @if(Session::has('DELIVERY_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('DELIVERY_UPDATE_SUCCESS')) !!}
    @endif

    {{-- DELETE TOAST --}}
    @if(Session::has('DELIVERY_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('DELIVERY_DELETE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection