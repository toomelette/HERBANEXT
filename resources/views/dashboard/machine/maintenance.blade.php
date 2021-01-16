<?php

  $table_sessions = [ 
	  Session::get('MACHINE_MNT_CREATE_SUCCESS_SLUG') ,
	  Session::get('MACHINE_MNT_UPDATE_SUCCESS_SLUG') ,
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
	<h1>Machine Maintenance</h1>
</section>

<section class="content">

	<div class="row">	

		<div class="col-md-12">
			<div class="box box-solid">
			<div class="box-header with-border">
				<h2 class="box-title">Add Schedule</h2>
			</div>

			<form method="POST" autocomplete="off" action="{{ route('dashboard.machine.maintenance_store') }}">

				<div class="box-body">

					@csrf

					{!! __form::select_dynamic(
						'6', 'machine_id', 'Machine *', old('machine_id'), $global_machines_all, 'machine_id', 'name', $errors->has('machine_id'), $errors->first('machine_id'), 'select2', ''
					) !!}  

			        {!! __form::textbox(
			         	'6', 'description', 'text', 'Description *', 'Description', old('description'), $errors->has('description'), $errors->first('description'), ''
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

					{!! __form::textbox(
						'12', 'remarks', 'text', 'Remarks', 'Remarks', old('remarks'), $errors->has('remarks'), $errors->first('remarks'), ''
					) !!} 

					<div class="col-md-12">
						<button type="submit" class="btn btn-default">Save <i class="fa fa-fw fa-save"></i></button>
					</div>

				</div>
			</form>

			</div>	
		</div>


		<div class="col-md-12">
    
			{{-- Form Start --}}
			<form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.machine.maintenance_index') }}">

			<div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

				{{-- Table Search --}}        
				<div class="box-header with-border">
				  {!! __html::table_search(route('dashboard.machine.maintenance_index')) !!}
				</div>
		  
			{{-- Form End --}}  
			</form>

				<div class="box-body no-padding">
					<table class="table table-hover">
						<tr>
							<th>@sortablelink('machine.name', 'Machine')</th>
							<th>@sortablelink('date_from', 'Datetime from')</th>
							<th>@sortablelink('date_to', 'Datetime To')</th>
							<th>@sortablelink('description', 'Description')</th>
							<th>@sortablelink('remarks', 'Remarks')</th>
							<th style="width: 150px">Action</th>
						</tr>
						@foreach($machine_maintenance_list as $data) 

							<tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
								
								<td id="mid-vert">{{ $data->machine->name }}</td>
								<td id="mid-vert">
									{{ __dataType::date_parse($data->date_from, 'm/d/Y') }} {{ date('h:i A', strtotime($data->time_from)) }}
								</td>
								<td id="mid-vert">
									{{ __dataType::date_parse($data->date_to, 'm/d/Y') }} {{ date('h:i A', strtotime($data->time_to)) }}
								</td>
								<td id="mid-vert">{{ $data->description }}</td>
								<td id="mid-vert">{{ $data->remarks }}</td>

								<td id="mid-vert">

									@if(in_array('dashboard.machine.maintenance_update', $global_user_submenus))

										<button
											 type="button" 
											 class="btn btn-default"
											 id="update_button"
											 data-url="{{ route('dashboard.machine.maintenance_update', $data->slug) }}"
											 data-machine_id="{{ $data->machine_id }}"
											 data-description="{{ $data->description }}"
											 data-date_from="{{ __dataType::date_parse($data->date_from, 'm/d/Y') }}"
											 data-date_to="{{ __dataType::date_parse($data->date_to, 'm/d/Y') }}"
											 data-time_from="{{ date('h:i A', strtotime($data->time_from)) }}"
											 data-time_to="{{ date('h:i A', strtotime($data->time_to)) }}"
											 data-remarks="{{ $data->remarks }}"
										>
												<i class="fa fa-pencil"></i>
										</button>

									@endif

									@if(in_array('dashboard.machine.maintenance_delete', $global_user_submenus))
										
										<button type="button" 
												 class="btn btn-default" 
												 id="delete_button" 
												 data-action="delete" 
												 data-url="{{ route('dashboard.machine.maintenance_delete', $data->slug) }}">
											<i class="fa fa-trash"></i>
										</button>

									@endif

								</td>
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
					{!! $machine_maintenance_list->appends($appended_requests)->render('vendor.pagination.bootstrap-4') !!}
				</div>

				</div>

			</div>	

		</div>
	

</section>

@endsection



@section('modals')

	{!! __html::modal_delete('machine_mnt_delete') !!}

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

			  {!! __form::select_dynamic(
				  '6', 'e_machine_id', 'Machine *', '', $global_machines_all, 'machine_id', 'name', $errors->has('e_machine_id'), $errors->first('e_machine_id'), 'select2', 'style="width:100%;"'
			  ) !!}  

			  {!! __form::textbox(
				   '6', 'e_description', 'text', 'Description *', 'Description', '', $errors->has('e_description'), $errors->first('e_description'), ''
			  ) !!}  

			  <div class="col-md-12"></div>

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

			  <div class="col-md-12"></div>

			  {!! __form::textbox(
				  '12', 'e_remarks', 'text', 'Remarks', 'Remarks', '', $errors->has('e_remarks'), $errors->first('e_remarks'), ''
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


    {!! __js::button_modal_confirm_delete_caller('machine_mnt_delete') !!}


    @if(Session::has('MACHINE_MNT_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('MACHINE_MNT_CREATE_SUCCESS')) !!}
    @endif


	@if(Session::has('MACHINE_MNT_DELETE_SUCCESS'))
	{!! __js::toast(Session::get('MACHINE_MNT_DELETE_SUCCESS')) !!}
	@endif


	@if(Session::has('MACHINE_MNT_UPDATE_SUCCESS'))
		{!! __js::toast(Session::get('MACHINE_MNT_UPDATE_SUCCESS')) !!}
	@endif
		

    $(document).on("click", "#update_button", function () {

		// Select2
		$('.select2').select2();

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
      $("#update_form #e_description").val($(this).data("description"));
      $("#update_form #e_machine_id").val($(this).data("machine_id")).change();
      $("#update_form #e_date_from").val($(this).data("date_from"));
      $("#update_form #e_time_from").val($(this).data("time_from"));
      $("#update_form #e_date_to").val($(this).data("date_to"));
      $("#update_form #e_time_to").val($(this).data("time_to"));
      $("#update_form #e_remarks").val($(this).data("remarks"));
    });


</script>

@endsection



