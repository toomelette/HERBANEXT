<?php

  $table_sessions = [ Session::get('TASK_UPDATE_SUCCESS_SLUG') ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

  $span_check = '<span class="badge bg-green"><i class="fa fa-check "></i></span>';
  $span_times = '<span class="badge bg-red"><i class="fa fa-times "></i></span>';

?>

@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Task List</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.task.index') }}">

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.task.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('name', 'Name')</th>
            <th>@sortablelink('description', 'Description')</th>
            <th>@sortablelink('item.name', 'Product')</th>
            <th>@sortablelink('machine.name', 'Machine')</th>
            <th>@sortablelink('is_scheduled', 'Scheduled')</th>
            <th style="width: 150px">Action</th>
          </tr>
          @foreach($tasks as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ $data->name }}</td>
              <td id="mid-vert">{{ $data->description }}</td>
              <td id="mid-vert">{{ optional($data->item)->name }}</td>
              <td id="mid-vert">{{ optional($data->machine)->name }}</td>
              <td id="mid-vert">{!! $data->is_scheduled == 1 ?  $span_check : $span_times !!}</td>
              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.task.edit', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.task.edit', $data->slug) }}">
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

@endsection





@section('modals')

  {!! __html::modal_delete('task_delete') !!}

@endsection 





@section('scripts')

  <script type="text/javascript">

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