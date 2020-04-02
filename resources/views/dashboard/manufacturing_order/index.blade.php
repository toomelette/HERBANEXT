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

    <div class="col-md-3">
	    <div class="box box-solid">
	      <div class="box-header with-border">
	        <h2 class="box-title">Search MO</h2>
	      </div>

	      <form data-pjax method="GET" autocomplete="off" action="{{ route('dashboard.manufacturing_order.index') }}">

	        <div class="box-body">

                {!! __form::textbox(
                  '12', 'q', 'text', 'Search', 'Search', old('q'), $errors->has('q'), $errors->first('q'), ''
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
	        <h2 class="box-title">Manufacturing Orders</h2>
	      </div>

	        <div class="box-body no-padding">
	        	<table class="table table-hover">
			          <tr>
			            <th>@sortablelink('po_no', 'Reference PO No.')</th>
			            <th>@sortablelink('jo_no', 'Reference JO No.')</th>
			            <th>@sortablelink('item_name', 'Product Name')</th>
			            <th>@sortablelink('updated_at', 'Date Updated')</th>
			            <th style="width: 150px">Action</th>
			          </tr>
			          @foreach($manufacturing_orders as $data) 
			            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
			              <td id="mid-vert">{{ $data->po_no }}</td>
			              <td id="mid-vert">{{ $data->jo_no }}</td>
			              <td id="mid-vert">{{ $data->item_name }}</td>
			              <td id="mid-vert">{{ __dataType::date_parse($data->updated_at, 'M d, Y h:i A') }}</td>
			              <td id="mid-vert">
			              	@if ($data->is_generated == false)
			                  @if(in_array('dashboard.manufacturing_order.fill_up', $global_user_submenus))
			                    <a href="{{ route('dashboard.manufacturing_order.fill_up', $data->slug) }}" type="button" class="btn btn-default">
			                      Fill Up
			                    </a>
			                  @endif
			              	@endif
			              </td>
			            </tr>
			            @endforeach
			          </table>
			      </div>

			      @if($manufacturing_orders->isEmpty())
			        <div style="padding :5px;">
			          <center><h4>No Records found!</h4></center>
			        </div>
			      @endif

			      <div class="box-footer">
			        {!! __html::table_counter($manufacturing_orders) !!}
			        {!! $manufacturing_orders->appends($appended_requests)->render('vendor.pagination.bootstrap-4') !!}
			      </div>

		      </div>

	    </div>	
    </div>

</section>

@endsection



@section('modals')

	@if(Session::has('JOB_ORDER_GENERATE_FILL_POST_SUCCESS'))
		{!! __html::modal_print(
	      'jo_generate_fill_post', '<i class="fa fa-fw fa-check"></i> Updated!', Session::get('JOB_ORDER_GENERATE_FILL_POST_SUCCESS'), route('dashboard.manufacturing_order.index', Session::get('JOB_ORDER_GENERATE_FILL_POST_SUCCESS_SLUG'))
	    ) !!}
	 @endif

@endsection



@section('scripts')

<script type="text/javascript">

    @if(Session::has('JOB_ORDER_GENERATE_FILL_POST_SUCCESS'))
      $('#jo_generate_fill_post').modal('show');
    @endif

</script>

@endsection



