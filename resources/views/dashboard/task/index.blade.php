<?php

  $table_sessions = [ Session::get('TASK_UPDATE_SUCCESS_SLUG') ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>

@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Task List</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.task.index') }}">

      {!! __html::filter_open() !!}


        {!! __form::select_dynamic_for_filter(
          '4', 'i', 'Product', old('i'), $global_items_all, 'item_id', 'name', 'submit_task_filter', 'select2', 'style="width:100%;"'
        ) !!}

        {!! __form::select_dynamic_for_filter(
          '4', 'm', 'Machine', old('m'), $global_machines_all, 'machine_id', 'name', 'submit_task_filter', 'select2', 'style="width:100%;"'
        ) !!}

        {!! __form::select_static_for_filter(
          '4', 's', 'Status', old('s'), ['UNSCHEDULED' => '1', 'WORKING' => '2', 'FINISHED' => '3'] , 'submit_task_filter', '', ''
        ) !!}

      {!! __html::filter_close('submit_task_filter') !!}

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.task.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-bordered">
          <tr>
            <th>@sortablelink('name', 'Name')</th>
            <th>@sortablelink('description', 'Description')</th>
            <th>@sortablelink('item.name', 'Product')</th>
            <th>@sortablelink('machine.name', 'Machine')</th>
            <th>@sortablelink('status', 'Status')</th>
            <th>@sortablelink('date_from', 'Date from')</th>
            <th>@sortablelink('date_to', 'Date to')</th>
            <th>@sortablelink('created_at', 'Date Encoded')</th>
            <th style="width:250px;">Action</th>
          </tr>
          @foreach($tasks as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ $data->name }}</td>
              <td id="mid-vert">{{ $data->description }}</td>
              <td id="mid-vert">{{ optional($data->item)->name }}</td>
              <td id="mid-vert">{{ optional($data->machine)->name }}</td>
              <td id="mid-vert">{!! $data->displayStatusSpan() !!}</td>
              <td id="mid-vert">{{ __dataType::date_parse($data->date_from, 'm/d/Y H:i') }}</td>
              <td id="mid-vert">{{ __dataType::date_parse($data->date_to, 'm/d/Y H:i') }}</td>
              <td id="mid-vert">{{ __dataType::date_parse($data->created_at, 'm/d/Y H:i') }}</td>
              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.task.update_finished', $global_user_submenus))
                    @if($data->status != 3)
                      <a type="button" class="btn btn-default" id="update_finished_button" data-action="update-finished" data-url="{{ route('dashboard.task.update_finished', $data->slug) }}">
                        Done
                      </a>
                    @endif
                  @endif
                  @if(in_array('dashboard.task.update_unfinished', $global_user_submenus))
                    @if($data->status == 3)
                      <a type="button" class="btn btn-default" id="update_unfinished_button" data-action="update-unfinished" data-url="{{ route('dashboard.task.update_unfinished', $data->slug) }}">
                        Ongiong
                      </a>
                    @endif
                  @endif
                  @if(in_array('dashboard.task.rate_personnel', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.task.rate_personnel', $data->slug) }}">
                      Rate
                    </a>
                  @endif
                  @if(in_array('dashboard.task.edit', $global_user_submenus))
                    <a type="button" 
                       class="btn btn-default" 
                       id="edit_button" 
                       href="{{ $data->status == 3 ? "#" : route('dashboard.task.edit', $data->slug)  }}"
                       {{ $data->status == 3 ? "disabled" : ""  }}>
                      <i class="fa fa-pencil"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.task.destroy', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.task.destroy', $data->slug) }}">
                      <i class="fa fa-trash"></i>
                    </a>
                  @endif
                </div>
              </tr>
            @endforeach
          </table>
      </div>

      @if($tasks->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($tasks) !!}
        {!! $tasks->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

  <form id="frm-update-finished" method="POST" style="display: none;">
    @csrf
  </form>

  <form id="frm-update-unfinished" method="POST" style="display: none;">
    @csrf
  </form>

@endsection





@section('modals')

  {!! __html::modal_delete('task_delete') !!}

@endsection 





@section('scripts')

  <script type="text/javascript">

    $(document).on("click", "#update_finished_button", function () {
      if($(this).data("action") == "update-finished"){
        $("#frm-update-finished").attr("action", $(this).data("url"));
        $("#frm-update-finished").submit();
      }
    });

    $(document).on("click", "#update_unfinished_button", function () {
      if($(this).data("action") == "update-unfinished"){
        $("#frm-update-unfinished").attr("action", $(this).data("url"));
        $("#frm-update-unfinished").submit();
      }
    });

    {{-- CALL CONFIRM DELETE MODAL --}}
    {!! __js::button_modal_confirm_delete_caller('task_delete') !!}

    {{-- UPDATE TOAST --}}
    @if(Session::has('TASK_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('TASK_UPDATE_SUCCESS')) !!}
    @endif

    {{-- DELETE TOAST --}}
    @if(Session::has('TASK_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('TASK_DELETE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection