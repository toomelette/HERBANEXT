<?php

  $table_sessions = [ 
	  Session::get('TASK_SCHEDULING_STORE_SUCCESS_SLUG'),
	];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>

@extends('layouts.admin-master')

@section('content')


<section class="content-header">
    <h1>Scheduling</h1>
    <div class="pull-right" style="margin-top: -27px;">
      <button class="btn btn-md btn-primary" id="add_button">
        <i class="fa fa-plus"></i> Add Schedule
      </button>
    </div> 
</section>

<section class="content">
  
  <div class="row">

    <div class="col-md-12">
    
			{{-- Form Start --}}
			<form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.task.scheduling_index') }}">

        {!! __html::filter_open() !!}
  
  
          {!! __form::select_dynamic_for_filter(
            '4', 'i', 'Product', old('i'), $global_items_all, 'item_id', 'name', 'submit_task_filter', 'select2', 'style="width:100%;"'
          ) !!}
  
          {!! __form::select_dynamic_for_filter(
            '4', 'm', 'Machine', old('m'), $global_machines_all, 'machine_id', 'name', 'submit_task_filter', 'select2', 'style="width:100%;"'
          ) !!}
  
          {!! __form::select_static_for_filter(
            '4', 's', 'Status', old('s'), ['WORKING' => '2', 'FINISHED' => '3'] , 'submit_task_filter', '', ''
          ) !!}
  
        {!! __html::filter_close('submit_task_filter') !!}

			<div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

				{{-- Table Search --}}        
				<div class="box-header with-border">
				  {!! __html::table_search(route('dashboard.task.scheduling_index')) !!}
				</div>
		  
			{{-- Form End --}}  
			</form>

				<div class="box-body no-padding">
					<table class="table table-hover">
						<tr>
              <th>@sortablelink('name', 'Name')</th>
              {{-- <th>@sortablelink('description', 'Description')</th>
              <th>@sortablelink('item.name', 'Product')</th>
              <th>@sortablelink('machine.name', 'Machine')</th> --}}
              <th>@sortablelink('status', 'Status')</th>
              <th>@sortablelink('date_from', 'Datetime from')</th>
              <th>@sortablelink('date_to', 'Datetime to')</th>
              <th>Action</th>
						</tr>
						@foreach($scheduled_tasks as $data) 

              <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
                
                <td id="mid-vert">{{ $data->name }}</td>
                {{-- <td id="mid-vert">{{ $data->description }}</td>
                <td id="mid-vert">{{ optional($data->item)->name }}</td>
                <td id="mid-vert">{{ optional($data->machine)->name }}</td> --}}
                <td id="mid-vert">{!! $data->displayStatusSpan() !!}</td>
                <td id="mid-vert">{{ __dataType::date_parse($data->date_from, 'm/d/Y h:i A') }}</td>
                <td id="mid-vert">{{ __dataType::date_parse($data->date_to, 'm/d/Y h:i A') }}</td>

								<td id="mid-vert">

									@if(in_array('dashboard.task.scheduling_update', $global_user_submenus))

										<button
											 type="button" 
											 class="btn btn-default"
											 id="update_button"
											 data-url="{{ route('dashboard.task.scheduling_update') }}"
											 data-slug="{{ $data->slug }}"
											 data-date_from="{{ __dataType::date_parse($data->date_from, 'm/d/Y') }}"
											 data-date_to="{{ __dataType::date_parse($data->date_to, 'm/d/Y') }}"
											 data-time_from="{{ date('h:i A', strtotime($data->date_from)) }}"
											 data-time_to="{{ date('h:i A', strtotime($data->date_to)) }}"
										>
												<i class="fa fa-pencil"></i>
										</button>

									@endif

									@if(in_array('dashboard.task.scheduling_rollback', $global_user_submenus))
										
										<button type="button" 
												    class="btn btn-danger" 
												    id="rollback_button" 
												    data-url="{{ route('dashboard.task.scheduling_rollback', $data->slug) }}">
											Rollback
										</button>

									@endif

								</td>
							</tr>

						@endforeach
					</table>

				</div>

				@if($scheduled_tasks->isEmpty())
					<div style="padding :5px;">
					<center><h4>No Records found!</h4></center>
					</div>
				@endif

				<div class="box-footer">
					{!! __html::table_counter($scheduled_tasks) !!}
					{!! $scheduled_tasks->appends($appended_requests)->render('vendor.pagination.bootstrap-4') !!}
				</div>

				</div>


  </div>

</section>

<form id="rollback_form" method="POST" style="display: none;">
  @csrf
</form>

@endsection




@section('modals')


  {{-- Add Schedule --}}
  <div class="modal fade" id="add_modal" data-backdrop="static">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <button class="close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 class="modal-title">Add Schedule</h4>
      </div>
      <div class="modal-body">

      <form method="POST" autocomplete="off" action="{{ route('dashboard.task.scheduling_store') }}">
        
        @csrf

        {!! __form::select_dynamic(
          '12', 'slug', 'Task *', old('slug'), $unscheduled_tasks, 'slug', 'name', $errors->has('slug'), $errors->first('slug'), 'select2', ''
        ) !!}

        {!! __form::datepicker(
          '3', 'date_from',  'Date From *', old('date_from') ? old('date_from') : Carbon::now()->format('m/d/Y'), $errors->has('date_from'), $errors->first('date_from')
        ) !!}

        {!! __form::timepicker(
          '3', 'time_from',  'Time From *', old('time_from'), $errors->has('time_from'), $errors->first('time_from')
        ) !!}

        {!! __form::datepicker(
          '3', 'date_to',  'Date To *', old('date_to') ? old('date_to') : Carbon::now()->format('m/d/Y'), $errors->has('date_to'), $errors->first('date_to')
        ) !!}

        {!! __form::timepicker(
          '3', 'time_to',  'Time To *', old('time_to'), $errors->has('time_to'), $errors->first('time_to')
        ) !!}

      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Save</button>
      </form>
      </div>
    </div>
    </div>
  </div>



  {{-- Update Schedule --}}
  <div class="modal fade" id="update_modal" data-backdrop="static">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <button class="close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 class="modal-title"> Update Schedule</h4>
      </div>
      <div class="modal-body" id="update_modal_body">
      <form method="POST" id="update_form">
        
        @csrf

        <input type="hidden" name="e_slug" id="e_slug">

        {!! __form::datepicker(
          '3', 'e_date_from',  'Date From *', '', $errors->has('e_date_from'), $errors->first('e_date_from')
        ) !!}

        {!! __form::timepicker(
          '3', 'e_time_from',  'Time From *', '', $errors->has('e_time_from'), $errors->first('e_time_from')
        ) !!}

        {!! __form::datepicker(
          '3', 'e_date_to',  'Date To *','', $errors->has('e_date_to'), $errors->first('e_date_to')
        ) !!}

        {!! __form::timepicker(
          '3', 'e_time_to',  'Time To *', '', $errors->has('e_time_to'), $errors->first('e_time_to')
        ) !!}

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


  @if(Session::has('TASK_SCHEDULING_STORE_SUCCESS'))
    {!! __js::toast(Session::get('TASK_SCHEDULING_STORE_SUCCESS')) !!}
  @endif
		


  // Add Schedule
  $(document).on("click", "#add_button", function () {

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

    $("#add_modal").modal("show");

  });



  // Update Schedule
  $(document).on("click", "#update_button", function () {

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

    $("#update_modal").modal("show");
    $("#update_modal_body #update_form").attr("action", $(this).data("url"));
    $("#update_form #e_slug").val($(this).data("slug"));
    $("#update_form #e_date_from").val($(this).data("date_from"));
    $("#update_form #e_time_from").val($(this).data("time_from"));
    $("#update_form #e_date_to").val($(this).data("date_to"));
    $("#update_form #e_time_to").val($(this).data("time_to"));

  });
		


  // Rollback Schedule
  $(document).on("click", "#rollback_button", function () {

      $("#rollback_form").attr("action", $(this).data("url"));
      $("#rollback_form").submit();
  
  });

</script>
    
@endsection