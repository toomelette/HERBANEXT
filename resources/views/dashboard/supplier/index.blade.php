<?php

  $table_sessions = [ Session::get('SUPPLIER_UPDATE_SUCCESS_SLUG') ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>





@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Supplier List</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.supplier.index') }}">

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.supplier.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('name', 'Name')</th>
            <th>@sortablelink('description', 'Description')</th>
            <th>@sortablelink('address', 'Address')</th>
            <th>@sortablelink('contact_email', 'Contact Email')</th>
            <th>@sortablelink('contact_person', 'Contact Person')</th>
            <th style="width: 150px">Action</th>
          </tr>
          @foreach($suppliers as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ $data->name }}</td>
              <td id="mid-vert">{{ $data->description }}</td>
              <td id="mid-vert">{{ $data->address }}</td>
              <td id="mid-vert">{{ $data->contact_email }}</td>
              <td id="mid-vert">{{ $data->contact_person }}</td>
              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.supplier.edit', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.supplier.edit', $data->slug) }}">
                      <i class="fa fa-pencil"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.supplier.destroy', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.supplier.destroy', $data->slug) }}">
                      <i class="fa fa-trash"></i>
                    </a>
                  @endif
                </div>
              </tr>
            @endforeach
          </table>
      </div>

      @if($suppliers->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($suppliers) !!}
        {!! $suppliers->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

@endsection





@section('modals')

  {!! __html::modal_delete('supplier_delete') !!}

@endsection 





@section('scripts')

  <script type="text/javascript">

    {{-- CALL CONFIRM DELETE MODAL --}}
    {!! __js::button_modal_confirm_delete_caller('supplier_delete') !!}

    {{-- UPDATE TOAST --}}
    @if(Session::has('SUPPLIER_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('SUPPLIER_UPDATE_SUCCESS')) !!}
    @endif

    {{-- DELETE TOAST --}}
    @if(Session::has('SUPPLIER_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('SUPPLIER_DELETE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection