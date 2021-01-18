<?php

  $table_sessions = [ Session::get('MACHINE_UPDATE_SUCCESS_SLUG') ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>





@extends('layouts.admin-master')

@section('content')

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.machine.index') }}">

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.machine.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('name', 'Name')</th>
            <th>@sortablelink('code', 'Machine Code')</th>
            <th>@sortablelink('description', 'Description')</th>
            <th>@sortablelink('location', 'Location')</th>
            <th>@sortablelink('status', 'Status')</th>
            <th style="width: 250px">Action</th>
          </tr>
          @foreach($machines as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ $data->name }}</td>
              <td id="mid-vert">{{ $data->code }}</td>
              <td id="mid-vert">{{ $data->description }}</td>
              <td id="mid-vert">{{ $data->location }}</td>
              <td id="mid-vert">{!! $data->displayStatus() !!}</td>
              <td id="mid-vert">

                @if(in_array('dashboard.machine.update_status', $global_user_submenus))

                  @if ($data->status == false || $data->status == null)

                    <button 
                      type="button" 
                      class="btn btn-default" 
                      id="update_status_button" 
                      data-url="{{ route('dashboard.machine.update_status', $data->slug) }}"
                      data-status="1"
                    >
                      Set to Available
                    </button>
                      
                  @else

                    <button 
                      type="button" 
                      class="btn btn-default" 
                      id="update_status_button" 
                      data-url="{{ route('dashboard.machine.update_status', $data->slug) }}"
                      data-status="0"
                    >
                      Set to Unavailable
                    </button>
                      
                  @endif
                @endif

                <div class="btn-group">
                  @if(in_array('dashboard.machine.edit', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.machine.edit', $data->slug) }}">
                      <i class="fa fa-pencil"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.machine.destroy', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.machine.destroy', $data->slug) }}">
                      <i class="fa fa-trash"></i>
                    </a>
                  @endif
                </div>
              </tr>
            @endforeach
          </table>
      </div>

      @if($machines->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($machines) !!}
        {!! $machines->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

  <form id="update-status-form" method="POST" style="display: none;">
    <input id="status" name="status">
    @csrf
  </form>

@endsection





@section('modals')

  {!! __html::modal_delete('machine_delete') !!}

@endsection 





@section('scripts')

  <script type="text/javascript">

    {{-- CALL CONFIRM DELETE MODAL --}}
    {!! __js::button_modal_confirm_delete_caller('machine_delete') !!}

    {{-- UPDATE TOAST --}}
    @if(Session::has('MACHINE_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('MACHINE_UPDATE_SUCCESS')) !!}
    @endif

    {{-- DELETE TOAST --}}
    @if(Session::has('MACHINE_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('MACHINE_DELETE_SUCCESS')) !!}
    @endif

    $(document).on("click", "#update_status_button", function () {
        $("#update-status-form").attr("action", $(this).data("url"));
        $("#update-status-form #status").val($(this).data("status"));
        $("#update-status-form").submit();
    });

  </script>
    
@endsection