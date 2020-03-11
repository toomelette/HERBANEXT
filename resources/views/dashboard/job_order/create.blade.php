<?php

  $table_sessions = [ ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>

@extends('layouts.admin-master')

@section('content')

<section class="content">

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
	        <h2 class="box-title">Result</h2>
	      </div>

	        <div class="box-body no-padding">
	        	<table class="table table-hover">
			          <tr>
			            <th>@sortablelink('po_no', 'PO No.')</th>
			            <th>@sortablelink('item.name', 'name')</th>
			            <th>@sortablelink('amount', 'amount')</th>
			            <th>@sortablelink('updated_at', 'Date')</th>
			            <th>@sortablelink('is_generated', 'Generated')</th>
			            <th style="width: 150px">Action</th>
			          </tr>
			          @foreach($po_items as $data) 
			            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
			              <td id="mid-vert">{{ $data->po_no }}</td>
			              <td id="mid-vert">{{ optional($data->item)->name }}</td>
			              <td id="mid-vert">
			                @if($data->unit != 'PCS')
			                  {{ number_format($data->amount, 3) }} {{ $data->unit }}
			                @else
			                  {{ number_format($data->amount) }} {{ $data->unit }}
			                @endif
			              </td>
			              <td id="mid-vert">{{ __dataType::date_parse($data->updated_at, 'M d, Y h:i A') }}</td>
			              <td id="mid-vert">
			                  @if($data->is_generated == false)
			                    <span class="badge bg-red"><i class="fa fa-fw fa-times"></i></span>
			                  @elseif($data->is_generated == true)
			                  	<span class="badge bg-green"><i class="fa fa-fw fa-check"></i></span>
			                  @endif
			              </td>
			              <td id="mid-vert">
			                  @if(in_array('dashboard.job_order.generate', $global_user_submenus))
			                    <a type="button" class="btn btn-default" id="generate_button" data-action="generate" data-url="{{ route('dashboard.job_order.generate', $data->slug) }}">
			                      Generate JO
			                    </a>
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

</section>

@endsection



@section('modals')
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
			         '6', 'jo_no', 'text', 'JO No. *', 'JO No.', old('jo_no'), $errors->has('jo_no'), $errors->first('jo_no'), 'required'
			        ) !!}  

			        {!! __form::textbox(
			         '6', 'no_of_batch', 'number', 'Number of Batch *', 'Number of Batch', old('no_of_batch'), $errors->has('no_of_batch'), $errors->first('no_of_batch'), 'required'
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
		
	$(document).on("click", "#generate_button", function () {
      if($(this).data("action") == "generate"){
        $("#generate").modal("show");
        $("#generate_body #form").attr("action", $(this).data("url"));
      }
    });

</script>

@endsection



