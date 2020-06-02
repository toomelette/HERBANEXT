<?php

  $table_sessions = [ Session::get('MACHINE_MNT_UPDATE_SUCCESS_SLUG') ];

  $appended_requests = [
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>


@extends('layouts.admin-master')

@section('content')

<section class="content">
            

  <div class="col-md-4">
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">New Maintenance Schedule</h2><br>
        <code>Fields with asterisks(*) are required</code>
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.machine_maintenance.store') }}">

        <div class="box-body">
                  
          @csrf    

          <input type="hidden" name="machine_id" value="{{ $machine->machine_id }}">

          {!! __form::datepicker(
            '6', 'date_from',  'Date From *', old('date_from') , $errors->has('date_from'), $errors->first('date_from')
          ) !!}

          {!! __form::timepicker(
            '6', 'time_from',  'Time From *', old('time_from'), $errors->has('time_from'), $errors->first('time_from')
          ) !!}

          <div class="col-md-12"></div>

          {!! __form::datepicker(
            '6', 'date_to',  'Date To *', old('date_to') , $errors->has('date_to'), $errors->first('date_to')
          ) !!}

          {!! __form::timepicker(
            '6', 'time_to',  'Time To *', old('time_to'), $errors->has('time_to'), $errors->first('time_to')
          ) !!}

          <div class="col-md-12"></div>

          {!! __form::textbox(
            '12', 'description', 'text', 'Description *', 'Description', old('description'), $errors->has('description'), $errors->first('description'), ''
          ) !!}

        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-default">Save <i class="fa fa-fw fa-save"></i></button>
        </div>

      </form>

    </div>
  </div>
            


  <div class="col-md-8 no-padding">
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">Maintenance Schedules</h2><br>
      </div>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('date_from', 'Date From')</th>
            <th>@sortablelink('date_to', 'Date To')</th>
            <th>@sortablelink('description', 'Description')</th>
            <th style="width: 200px">Action</th>
          </tr>
          @foreach($machine_maintenance_list as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">
                {{ __dataType::date_parse($data->date_from, 'F d, Y') }}
                {{ __dataType::date_parse($data->time_from, 'h:i A') }}
              </td>
              <td id="mid-vert">
                {{ __dataType::date_parse($data->date_to, 'F d, Y') }}
                {{ __dataType::date_parse($data->time_to, 'h:i A') }}
              </td>
              <td id="mid-vert">{{ $data->description }}</td>
              <td id="mid-vert">

                @if(in_array('dashboard.machine_maintenance.update', $global_user_submenus))
                  <a type="button" 
                     class="btn btn-default" 
                     id="update_button" 
                     data-action="update"
                     slug="{{ $data->slug }}"  
                     data-url="{{ route('dashboard.machine_maintenance.update', $data->slug) }}">
                    <i class="fa fa-pencil"></i>
                  </a>
                @endif

                @if(in_array('dashboard.machine_maintenance.destroy', $global_user_submenus))
                  <a type="button" 
                     class="btn btn-default" 
                     id="delete_button" 
                     data-action="delete" 
                     data-url="{{ route('dashboard.machine_maintenance.destroy', $data->slug) }}">
                    <i class="fa fa-trash"></i>
                  </a>
                @endif

              </tr>
            @endforeach
          </table>
      </div>

      @if($machine_maintenance_list->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($machine_maintenance_list) !!}
        {!! $machine_maintenance_list->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>
  </div>



</section>

@endsection





@section('modals')


  {!! __html::modal_delete('machine_mnt_delete') !!}


  {{-- Update Modal --}}
  <div class="modal fade bs-example-modal-sm" id="update_modal" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body" id="update_body">
          <form data-pjax id="update_form" method="POST" autocomplete="off">

            <div class="row">
                
              @csrf

              <input name="_method" value="PUT" type="hidden">

              {!! __form::datepicker(
                '6', 'e_date_from',  'Date From *', old('e_date_from'), $errors->has('e_date_from'), $errors->first('e_date_from')
              ) !!}

              {!! __form::timepicker(
                '6', 'e_time_from',  'Time From *', old('e_time_from'), $errors->has('e_time_from'), $errors->first('e_time_from')
              ) !!}

              <div class="col-md-12"></div>
              
              {!! __form::datepicker(
                '6', 'e_date_to',  'Date To *', old('e_date_to'), $errors->has('e_date_to'), $errors->first('e_date_to')
              ) !!}

              {!! __form::timepicker(
                '6', 'e_time_to',  'Time To *', old('e_time_to'), $errors->has('e_time_to'), $errors->first('e_time_to')
              ) !!}

              {!! __form::textbox(
                '12', 'e_description', 'text', 'Description *', 'Description', old('e_description'), $errors->has('e_description'), $errors->first('e_description'), ''
              ) !!}

            </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-default">Save <i class="fa fa-fw fa-save"></i></button>
        </div>
        </form>
      </div>
    </div>
  </div>


@endsection 




@section('scripts')

  <script type="text/javascript">


    @if(Session::has('MACHINE_MNT_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('MACHINE_MNT_CREATE_SUCCESS')) !!}
    @endif


    {!! __js::button_modal_confirm_delete_caller('machine_mnt_delete') !!}


    @if(Session::has('MACHINE_MNT_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('MACHINE_MNT_DELETE_SUCCESS')) !!}
    @endif


    @if(Session::has('MACHINE_MNT_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('MACHINE_MNT_UPDATE_SUCCESS')) !!}
    @endif


    // Update Button Action
    $(document).on("click", "#update_button", function () {

      var slug = $(this).attr("slug");

      $("#update_modal").modal("show");
      $("#update_body #update_form").attr("action", $(this).data("url"));

      // Date Picker
      $('.datepicker').each(function(){
          $(this).datepicker({
              autoclose: true,
              dateFormat: "mm/dd/yy",
              orientation: "bottom"
          });
      });

      // Time Picker
      $('.timepicker').timepicker({
        showInputs: false,
        minuteStep: 1,
        showMeridian: true,
      });

      $.ajax({
        headers: {"X-CSRF-TOKEN": $('meta[name="cwpef-token"]').attr("content")},
          url: "/api/machine_maintenance/"+slug+"/edit",
          type: "GET",
          dataType: "json",
          success:function(data) {       
            
            $.each(data, function(key, value) {
              $("#update_form #e_date_from").val(value.date_from);
              $("#update_form #e_time_from").val(value.time_from);
              $("#update_form #e_date_to").val(value.date_to);
              $("#update_form #e_time_to").val(value.time_to);
              $("#update_form #e_description").val(value.description);
            });

          }
      });

    });

  </script>
    
@endsection