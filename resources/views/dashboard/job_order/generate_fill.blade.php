<?php

	$unit_type_list = [];

	if ($po_item->unit_type_id == 'IU1001') {
		$unit_type_list = ['PCS' => 'PCS', ];
	}elseif ($po_item->unit_type_id == 'IU1002') {
		$unit_type_list = ['GRAM' => 'GRAM', 'KILOGRAM' => 'KILOGRAM'];
	}elseif ($po_item->unit_type_id == 'IU1003') {
		$unit_type_list = ['MILLILITRE' => 'MILLILITRE', 'LITRE' => 'LITRE'];
	}

	$jobOrder = $po_item->jobOrder->toArray();
	
?>
@extends('layouts.admin-master')

@section('content')

<section class="content">

<form data-pjax method="POST" autocomplete="off" action="{{ route('dashboard.job_order.generate_fill_post', $po_item->slug) }}">

	@csrf

    <div class="col-md-12">
	    <div class="box box-solid">
	      <div class="box-header with-border">
	        <h2 class="box-title">Fill JO Batches</h2>
	        <div class="pull-right">
	            <code>Fields with asterisks(*) are required</code>
	            &nbsp;
	            {!! __html::back_button(['dashboard.job_order.create']) !!}
			</div> 
	      </div>

	        <div class="box-body">

	        	@if (old('row'))
	        			
	        		@foreach (old('row') as $key => $data)

		        		<div class="col-md-6" style="margin-bottom:20px;">
						    <div class="box">
						      <div class="box-header with-border">
						        <h2 class="box-title">#{{ $key + 1 }}</h2>
						      </div>
						        <div class="content box-body">

						        	<input type="hidden" name="row[{{ $key }}][jo_id]" id="jo_id" value="{{ $jobOrder[$key]['jo_id'] }}">
						        	<input type="hidden" name="item_type_percent" id="item_type_percent" value="{{ $po_item->item_type_percent }}">
						        	<input type="hidden" name="unit_type_id" id="unit_type_id" value="{{ $po_item->unit_type_id }}">

					                {!! __form::textbox(
					                  '6', '', 'text', 'Reference PO Number', 'PO Number', $jobOrder[$key]['po_no'], '', '', 'readonly'
					                ) !!}  

		                            <div class="form-group col-md-6">
						              <label for="jo_no">JO No.</label>
		                              <input type="text" name="row[{{ $key }}][jo_no]" id="jo_no" class="form-control jo_no" placeholder="JO No." value="{{ $data['jo_no'] }}">
						              <small class="text-danger">{{ $errors->first('row.'. $key .'.jo_no') }}</small>
		                            </div>

					                <div class="col-md-12"></div>

					                {!! __form::textbox(
					                  '12', '', 'text', 'Product Name', 'Product Name', $jobOrder[$key]['item_name'], '', '', 'readonly'
					                ) !!} 

					                <div class="col-md-12"></div>

							        <div class="form-group col-md-6" style="overflow:hidden;">
						                <label for="">Date Required</label>
						                <div class="input-group">
						                  <div class="input-group-addon">
						                    <i class="fa fa-calendar"></i>
						                  </div>
						                  <input id="date" name="row[{{ $key }}][date]" value="{{ __dataType::date_parse($data['date'], 'm/d/Y') }}" type="text" class="form-control datepicker date" placeholder="mm/dd/yy">
						                </div>
						                <small class="text-danger">{{ $errors->first('row.'. $key .'.date') }}</small>
					              	</div>

					                {!! __form::textbox(
					                  '6', '', 'text', 'Qty Required', 'Qty Required', number_format($jobOrder[$key]['amount'], 3) .' '. $jobOrder[$key]['unit'], '', '', 'readonly'
					                ) !!}	

					                <div class="col-md-12"></div>

		                            <div class="form-group col-md-6">
						              <label for="batch_size">Batch Size</label>
		                              <input type="text" name="row[{{ $key }}][batch_size]" id="batch_size" class="form-control batch_size" placeholder="Batch Size" value="{{ $data['batch_size'] }}">
						              <small class="text-danger">{{ $errors->first('row.'. $key .'.batch_size') }}</small>
		                            </div> 

		                            <div class="form-group col-md-6">
						              <label for="lot_no">Lot No.</label>
		                              <input type="text" name="row[{{ $key }}][lot_no]" id="lot_no" class="form-control lot_no" placeholder="Lot No." value="{{ $data['lot_no'] }}">
						              <small class="text-danger">{{ $errors->first('row.'. $key .'.lot_no') }}</small>
		                            </div>

					                <div class="col-md-12"></div>

		                            <div class="form-group col-md-6">
						              <label for="pack_size">Pack Size</label>
		                              <input type="text" name="row[{{ $key }}][pack_size]" id="pack_size" class="form-control pack_size" placeholder="Pack Size" value="{{ $data['pack_size'] }}">
						              <small class="text-danger">{{ $errors->first('row.'. $key .'.pack_size') }}</small>
		                            </div>

		                            <div class="form-group col-md-6">
						              <label for="theo_yield">Theoritical Yield</label>
		                              <input type="text" name="row[{{ $key }}][theo_yield]" id="theo_yield" class="form-control theo_yield" placeholder="Theoritical Yield" value="{{ $data['theo_yield'] }}">
						              <small class="text-danger">{{ $errors->first('row.'. $key .'.theo_yield') }}</small>
		                            </div>

						        </div>
						    </div>	
		        		</div>

	        		@endforeach

	        	@else

		        	@foreach ($po_item->jobOrder as $key => $data)

		        		<div class="col-md-6" style="margin-bottom:20px;">
						    <div class="box">
						      <div class="box-header with-border">
						        <h2 class="box-title">#{{ $key + 1 }}</h2>
						      </div>
						        <div class="content box-body">

						        	<input type="hidden" name="row[{{ $key }}][jo_id]" id="jo_id" value="{{ $data->jo_id }}">
						        	<input type="hidden" name="item_type_percent" id="item_type_percent" value="{{ $po_item->item_type_percent }}">
						        	<input type="hidden" name="unit_type_id" id="unit_type_id" value="{{ $po_item->unit_type_id }}">

					                {!! __form::textbox(
					                  '6', '', 'text', 'Reference PO Number', 'PO Number', $data->po_no, '', '', 'readonly'
					                ) !!}  

		                            <div class="form-group col-md-6">
						              <label for="jo_no">JO No.</label>
		                              <input type="text" name="row[{{ $key }}][jo_no]" id="jo_no" class="form-control jo_no" placeholder="JO No." value="{{ $data->jo_no }}">
		                            </div>

					                <div class="col-md-12"></div>

					                {!! __form::textbox(
					                  '12', '', 'text', 'Product Name', 'Product Name', $data->item_name, '', '', 'readonly'
					                ) !!} 

					                <div class="col-md-12"></div>

							        <div class="form-group col-md-6" style="overflow:hidden;">
						                <label for="">Date Required</label>
						                <div class="input-group">
						                  <div class="input-group-addon">
						                    <i class="fa fa-calendar"></i>
						                  </div>
						                  <input id="date" name="row[{{ $key }}][date]" value="{{ __dataType::date_parse($data->date, 'm/d/Y') }}" type="text" class="form-control datepicker date" placeholder="mm/dd/yy">
						                </div>
					              	</div>

					                {!! __form::textbox(
					                  '6', '', 'text', 'Qty Required', 'Qty Required', number_format($data->amount, 3) .' '. $data->unit, '', '', 'readonly'
					                ) !!}	

					                <div class="col-md-12"></div>

		                            <div class="form-group col-md-6">
						              <label for="batch_size">Batch Size</label>
		                              <input type="text" name="row[{{ $key }}][batch_size]" id="batch_size" class="form-control batch_size" placeholder="Batch Size" value="{{ $data->batch_size }}">
		                            </div> 

		                            <div class="form-group col-md-6">
						              <label for="lot_no">Lot No.</label>
		                              <input type="text" name="row[{{ $key }}][lot_no]" id="lot_no" class="form-control lot_no" placeholder="Lot No." value="{{ $data->lot_no }}">
		                            </div>

					                <div class="col-md-12"></div>

		                            <div class="form-group col-md-6">
						              <label for="pack_size">Pack Size</label>
		                              <input type="text" name="row[{{ $key }}][pack_size]" id="pack_size" class="form-control pack_size" placeholder="Pack Size" value="{{ $data->pack_size }}">
		                            </div>

		                            <div class="form-group col-md-6">
						              <label for="theo_yield">Theoritical Yield</label>
		                              <input type="text" name="row[{{ $key }}][theo_yield]" id="theo_yield" class="form-control theo_yield" placeholder="Theoritical Yield" value="{{ $data->theo_yield }}">
		                            </div>

						        </div>
						    </div>	
		        		</div>

				    @endforeach

	        	@endif
	        

	        </div>

	      	<div class="box-footer">
            	<button type="submit" class="btn btn-default">Save <i class="fa fa-fw fa-save"></i></button>
	      	</div>
	    
	    </div>	
    </div>

</form>

</section>

@endsection




