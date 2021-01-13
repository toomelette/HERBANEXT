<?php

  $table_sessions = [ Session::get('JOB_ORDER_GENERATE_FILL_POST_SUCCESS_SLUG') ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>

@extends('layouts.admin-master')

@section('content')

<section class="content">

	<div class="row">	

		<div class="col-md-3">
			<div class="box box-solid">
			<div class="box-header with-border">
				<h2 class="box-title">Search PO</h2>
			</div>

			<form data-pjax method="GET" autocomplete="off" action="{{ route('dashboard.job_order.create') }}">

				<div class="box-body">

					{!! __form::textbox(
					'12', 'q', 'text', 'PO Number *', 'PO Number', old('q'), $errors->has('q'), $errors->first('q'), ''
					) !!}  

					<div class="col-md-12">
						<button type="submit" class="btn btn-default">Search <i class="fa fa-fw fa-search"></i></button>
					</div>

				</div>
			</form>

			</div>	
		</div>

		<div class="col-md-9">
			<div class="box box-solid">
			<div class="box-header with-border">
				<h2 class="box-title">PO Items</h2>
			</div>

				<div class="box-body no-padding">
					<table class="table table-hover">
						<tr>
							<th>@sortablelink('po_no', 'PO No.')</th>
							<th>@sortablelink('item.name', 'Name')</th>
							<th>@sortablelink('amount', 'Quantity')</th>
							<th>@sortablelink('updated_at', 'Date')</th>
							<th>@sortablelink('delivery_status', 'Delivery Status')</th>
							<th style="width: 150px">Action</th>
						</tr>
						@foreach($po_items as $data) 
							<tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
							<td id="mid-vert">{{ $data->po_no }}</td>
							<td id="mid-vert">{{ optional($data->item)->name }}</td>
							<td id="mid-vert">{!! $data->displayAmount() !!}</td>
							<td id="mid-vert">{{ __dataType::date_parse($data->updated_at, 'm/d/Y h:i A') }}</td>
							<td id="mid-vert">{!! $data->isReadyForDeliverySpan() !!}</td>

							<td id="mid-vert">
								@if ($data->is_generated == false)
								@if(in_array('dashboard.job_order.generate', $global_user_submenus))
									<a type="button" class="btn btn-default" id="generate_button" data-action="generate" data-url="{{ route('dashboard.job_order.generate', $data->slug) }}">
									Generate JO
									</a>
								@endif
								@else
								@if(in_array('dashboard.job_order.show', $global_user_submenus))
									<a href="{{ route('dashboard.job_order.show', $data->slug) }}" type="button" class="btn btn-default">
									<i class="fa fa-print"></i>
									</a>
								@endif
								@if(in_array('dashboard.job_order.generate_fill', $global_user_submenus))
									<a href="{{ route('dashboard.job_order.generate_fill', $data->slug) }}" type="button" class="btn btn-default">
									Edit JO
									</a>
								@endif
								@endif
							</td>
							
							</tr>
							@endforeach
						</table>
					</div>

					@if($po_items->isEmpty())
						<div style="padding :5px;">
						<center><h4>No Records found!</h4></center>
						</div>
					@endif

					<div class="box-footer">
						{!! __html::table_counter($po_items) !!}
						{!! $po_items->appends($appended_requests)->render('vendor.pagination.bootstrap-4') !!}
					</div>

				</div>

			</div>	
		</div>

    </div>

</section>

@endsection



@section('modals')

	@if(Session::has('JOB_ORDER_GENERATE_FILL_POST_SUCCESS'))

		{!! __html::modal_print(
	      'jo_generate_fill_post', '<i class="fa fa-fw fa-check"></i> Updated!', Session::get('JOB_ORDER_GENERATE_FILL_POST_SUCCESS'), route('dashboard.job_order.show', Session::get('JOB_ORDER_GENERATE_FILL_POST_SUCCESS_SLUG'))
	    ) !!}

	@endif

	<div class="modal fade" id="generate" data-backdrop="static">
		<div class="modal-dialog">
		  <div class="modal-content">
		    <div class="modal-header">
		      <button class="close" data-dismiss="modal">
		        <span aria-hidden="true">&times;</span>
		      </button>
		      <h4 class="modal-title"><i class="fa fa-refresh "></i> Generate</h4>
		    </div>
		    <div class="modal-body" id="generate_body">
		      <form method="POST" id="form">
		        
		        @csrf
		        
		        <div class="row">
			        {!! __form::textbox(
			         '12', 'no_of_batch', 'number', 'Number of Batch *', 'Number of Batch', old('no_of_batch'), $errors->has('no_of_batch'), $errors->first('no_of_batch'), 'required'
			        ) !!}  	
		        </div>

		      </div>
		      <div class="modal-footer">
		        <button class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-success">Generate</button>
		      </form>
		    </div>
		  </div>
		</div>
	</div>

@endsection



@section('scripts')

<script type="text/javascript">

    {{-- Print JO Confirmation --}}
    @if(Session::has('JOB_ORDER_GENERATE_FILL_POST_SUCCESS'))
      $('#jo_generate_fill_post').modal('show');
    @endif
		
	$(document).on("click", "#generate_button", function () {
      if($(this).data("action") == "generate"){
        $("#generate").modal("show");
        $("#generate_body #form").attr("action", $(this).data("url"));
      }
    });

</script>

@endsection



