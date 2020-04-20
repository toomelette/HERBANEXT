<?php

  $table_sessions = [ Session::get('FO_FILL_UP_POST_SUCCESS_SLUG') ];

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
	        <h2 class="box-title">Search FO</h2>
	      </div>

	      <form data-pjax method="GET" autocomplete="off" action="{{ route('dashboard.finishing_order.index') }}">

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
	        <h2 class="box-title">Finishing Orders</h2>
	      </div>

	        <div class="box-body no-padding">
	        	<table class="table table-hover">
			          <tr>
			            <th>@sortablelink('jobOrder.po_no', 'Reference PO No.')</th>
			            <th>@sortablelink('jobOrder.jo_no', 'Reference JO No.')</th>
			            <th>@sortablelink('jobOrder.item_name', 'Product Name')</th>
			            <th>@sortablelink('updated_at', 'Date Updated')</th>
			            <th style="width: 150px">Action</th>
			          </tr>
			          @foreach($finishing_orders as $data) 
			            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
			              <td id="mid-vert">{{ optional($data->jobOrder)->po_no }}</td>
			              <td id="mid-vert">{{ optional($data->jobOrder)->jo_no }}</td>
			              <td id="mid-vert">{{ optional($data->jobOrder)->item_name }}</td>
			              <td id="mid-vert">{{ __dataType::date_parse($data->updated_at, 'M d, Y h:i A') }}</td>
			              <td id="mid-vert">
			                @if(in_array('dashboard.finishing_order.show', $global_user_submenus))
			                    <a href="{{ route('dashboard.finishing_order.show', $data->slug) }}" type="button" class="btn btn-default">
			                      <i class="fa fa-print"></i>
			                    </a>
			                @endif
			                @if(in_array('dashboard.finishing_order.fill_up', $global_user_submenus))
			                    <a href="{{ route('dashboard.finishing_order.fill_up', $data->slug) }}" type="button" class="btn btn-default">
			                      Fill Up
			                    </a>
			                @endif
			              </td>
			            </tr>
			            @endforeach
			          </table>
			      </div>

			      @if($finishing_orders->isEmpty())
			        <div style="padding :5px;">
			          <center><h4>No Records found!</h4></center>
			        </div>
			      @endif

			      <div class="box-footer">
			        {!! __html::table_counter($finishing_orders) !!}
			        {!! $finishing_orders->appends($appended_requests)->render('vendor.pagination.bootstrap-4') !!}
			      </div>

		      </div>

	    </div>	
    </div>

</section>

@endsection



@section('modals')

	@if(Session::has('FO_FILL_UP_POST_SUCCESS'))
		{!! __html::modal_print(
	      'fo_fill_up_post', '<i class="fa fa-fw fa-check"></i> Posted!', Session::get('FO_FILL_UP_POST_SUCCESS'), route('dashboard.finishing_order.show', Session::get('FO_FILL_UP_POST_SUCCESS_SLUG'))
	    ) !!}
	 @endif

@endsection



@section('scripts')

<script type="text/javascript">

    @if(Session::has('FO_FILL_UP_POST_SUCCESS'))
      $('#fo_fill_up_post').modal('show');
    @endif

</script>

@endsection



