<?php

	$unit_type_list = [];

	if ($po_item->unit_type_id == 'IU1001') {
		$unit_type_list = ['PCS' => 'PCS', ];
	}elseif ($po_item->unit_type_id == 'IU1002') {
		$unit_type_list = ['GRAM' => 'GRAM', 'KILOGRAM' => 'KILOGRAM'];
	}elseif ($po_item->unit_type_id == 'IU1003') {
		$unit_type_list = ['MILLILITRE' => 'MILLILITRE', 'LITRE' => 'LITRE'];
	}

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
	        		
	        		@foreach (old('row') as $row_key => $row_data)
	        			
	        			@foreach ($po_item->jobOrder as $key => $data)

			        		<div class="col-md-6" style="margin-bottom:20px;">
							    <div class="box">
							      <div class="box-header with-border">
							        <h2 class="box-title">#{{ $key + 1 }}</h2>
							      </div>
							        <div class="content box-body">

							        	<input type="hidden" name="batch_size" id="batch_size" value="{{ $data->batch_size }}">
							        	<input type="hidden" name="batch_size_unit" id="batch_size_unit" value="{{ $data->batch_size_unit }}">
							        	<input type="hidden" name="item_type_percent" id="item_type_percent" value="{{ $po_item->item_type_percent }}">
							        	<input type="hidden" name="unit_type_id" id="unit_type_id" value="{{ $po_item->unit_type_id }}">

						                {!! __form::textbox(
						                  '6', '', 'text', 'Reference PO Number', 'PO Number', $data->po_no, '', '', 'readonly'
						                ) !!}  

						                {!! __form::textbox(
						                  '6', '', 'text', 'JO Number', 'JO Number', $data->jo_no, '', '', 'readonly'
						                ) !!} 

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
							                  <input id="date" name="row[{{ $key }}][date]" value="{{ __dataType::date_parse($row_data['date']) }}" type="text" class="form-control datepicker date" placeholder="mm/dd/yy">
							                </div>
							                <small class="text-danger">{{ $errors->first('row.'. $row_key .'.date') }}</small>
						              	</div>

						                {!! __form::textbox(
						                  '6', '', 'text', 'Qty Required', 'Qty Required', number_format($data->amount, 3) .' '. $data->unit, '', '', 'readonly'
						                ) !!}	

						                <div class="col-md-12"></div>

						                {!! __form::textbox(
						                  '6', '', 'text', 'Batch Size', 'Batch Size', number_format($data->batch_size, 3) .' '. $data->batch_size_unit, '', '', 'readonly'
						                ) !!}  

							            {!! __form::textbox(
							              '6', 'jo_lot_no', 'text', 'Lot No. *', 'Lot No.', old('jo_lot_no'), $errors->has('jo_lot_no'), $errors->first('jo_lot_no'), ''
							            ) !!}

			                            <div class="form-group col-md-6">
							              <label for="pack_size">Pack Size</label>
			                              <input type="text" name="row[{{ $key }}][pack_size]" id="pack_size" class="form-control pack_size" placeholder="Pack Size" value="{{ $row_data['pack_size'] }}">
							              <small class="text-danger">{{ $errors->first('row.'. $row_key .'.pack_size') }}</small>
			                            </div>

			                            <div class="form-group col-md-6">
							              <label for="pack_size_unit">Pack Size Unit</label>
			                              <input type="text" name="row[{{ $key }}][pack_size_unit]" id="pack_size_unit" class="form-control pack_size_unit" placeholder="Pack Size Unit" value="{{ $row_data['pack_size_unit'] }}">
							              <small class="text-danger">{{ $errors->first('row.'. $row_key .'.pack_size_unit') }}</small>
			                            </div>

						                <div class="col-md-12"></div>

			                            <div class="form-group col-md-6">
							              <label for="theo_yield">Theoritical Yield</label>
			                              <input type="text" name="row[{{ $key }}][theo_yield]" id="theo_yield" class="form-control theo_yield" placeholder="Theoritical Yield" value="{{ $row_data['theo_yield'] }}" readonly="readonly">
							              <small class="text-danger">{{ $errors->first('row.'. $row_key .'.theo_yield') }}</small>
			                            </div>

			                            <div class="form-group col-md-6">
							              <label for="theo_yield_unit">Theoritical Yield Unit</label>
			                              <input type="text" name="row[{{ $key }}][theo_yield_unit]" id="theo_yield_unit" class="form-control theo_yield_unit" placeholder="Theoritical Yield Unit" value="{{ $row_data['theo_yield_unit'] }}" readonly="readonly">
							              <small class="text-danger">{{ $errors->first('row.'. $row_key .'.theo_yield_unit') }}</small>
			                            </div>

							        </div>
							    </div>	
			        		</div>

					    @endforeach

	        		@endforeach

	        	@else

		        	@foreach ($po_item->jobOrder as $key => $data)

		        		<div class="col-md-6" style="margin-bottom:20px;">
						    <div class="box">
						      <div class="box-header with-border">
						        <h2 class="box-title">#{{ $key + 1 }}</h2>
						      </div>
						        <div class="content box-body">

						        	<input type="hidden" name="batch_size" id="batch_size" value="{{ $data->batch_size }}">
						        	<input type="hidden" name="batch_size_unit" id="batch_size_unit" value="{{ $data->batch_size_unit }}">
						        	<input type="hidden" name="item_type_percent" id="item_type_percent" value="{{ $po_item->item_type_percent }}">
						        	<input type="hidden" name="unit_type_id" id="unit_type_id" value="{{ $po_item->unit_type_id }}">

					                {!! __form::textbox(
					                  '6', '', 'text', 'Reference PO Number', 'PO Number', $data->po_no, '', '', 'readonly'
					                ) !!}  

					                {!! __form::textbox(
					                  '6', '', 'text', 'JO Number', 'JO Number', $data->jo_no, '', '', 'readonly'
					                ) !!} 

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
						                  <input id="date" name="row[{{ $key }}][date]" value="{{ __dataType::date_parse($data->date) }}" type="text" class="form-control datepicker date" placeholder="mm/dd/yy">
						                </div>
					              	</div>

					                {!! __form::textbox(
					                  '6', '', 'text', 'Qty Required', 'Qty Required', number_format($data->amount, 3) .' '. $data->unit, '', '', 'readonly'
					                ) !!}	

					                <div class="col-md-12"></div>

					                {!! __form::textbox(
					                  '6', '', 'text', 'Batch Size', 'Batch Size', number_format($data->batch_size, 3) .' '. $data->batch_size_unit, '', '', 'readonly'
					                ) !!}  

						            {!! __form::textbox(
						              '6', 'jo_lot_no', 'text', 'Lot No. *', 'Lot No.', old('jo_lot_no'), $errors->has('jo_lot_no'), $errors->first('jo_lot_no'), ''
						            ) !!}

		                            <div class="form-group col-md-6">
						              <label for="pack_size">Pack Size</label>
		                              <input type="text" name="row[{{ $key }}][pack_size]" id="pack_size" class="form-control pack_size" placeholder="Pack Size" value="{{ $data->pack_size }}">
		                            </div>

		                            <div class="form-group col-md-6">
						              <label for="pack_size_unit">Pack Size Unit</label>
		                              <input type="text" name="row[{{ $key }}][pack_size_unit]" id="pack_size_unit" class="form-control pack_size_unit" placeholder="Pack Size Unit" value="{{ $data->pack_size_unit }}">
		                            </div>

						            <div class="col-md-12"></div>

		                            <div class="form-group col-md-6">
						              <label for="theo_yield">Theoritical Yield</label>
		                              <input type="text" name="row[{{ $key }}][theo_yield]" id="theo_yield" class="form-control theo_yield" placeholder="Theoritical Yield" value="{{ $data->theo_yield }}" readonly="readonly">
		                            </div>

		                            <div class="form-group col-md-6">
						              <label for="theo_yield_unit">Theoritical Yield Unit</label>
		                              <input type="text" name="row[{{ $key }}][theo_yield_unit]" id="theo_yield_unit" class="form-control theo_yield_unit" placeholder="Theoritical Yield Unit" value="{{ $data->theo_yield_unit }}" readonly="readonly">
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




@section('scripts')
	
	<script type="text/javascript">
	

		$('.pack_size').priceFormat({
		    centsLimit: 3,
		    prefix: "",
		    thousandsSeparator: ",",
		    clearOnEmpty: true,
		    allowNegative: false
		});


	    $(".pack_size").keyup(function() {

	    	pack_size = $(this).val();
	    	batch_size = $(this).closest('div.content').find('input[id=batch_size]').val();
	    	percent = $(this).closest('div.content').find('input[id=item_type_percent]').val() / 100;
	    	unit_type_id = $(this).closest('div.content').find('input[id=unit_type_id]').val();

	    	pack_size = parseFloat(pack_size);
	    	batch_size = parseFloat(batch_size);
	    	percent = parseFloat(percent);

	    	theo_yield = batch_size * percent;
	    	theo_yield = theo_yield * 1000;
	    	theo_yield = theo_yield / pack_size;

			$(this).closest('div.content').find('input[id=theo_yield]').val(parseFloat(theo_yield).toFixed(3));

			$($(this).closest('div.content').find('input[id=theo_yield]')).priceFormat({
			    centsLimit: 3,
			    prefix: "",
			    thousandsSeparator: ",",
			    clearOnEmpty: true,
			    allowNegative: false
			});

		});


	    $(".pack_size").keydown(function() {

	    	pack_size = $(this).val();
	    	batch_size = $(this).closest('div.content').find('input[id=batch_size]').val();
	    	percent = $(this).closest('div.content').find('input[id=item_type_percent]').val() / 100;
	    	unit_type_id = $(this).closest('div.content').find('input[id=unit_type_id]').val();

	    	pack_size = parseFloat(pack_size);
	    	batch_size = parseFloat(batch_size);
	    	percent = parseFloat(percent);

	    	theo_yield = batch_size * percent;
	    	theo_yield = theo_yield * 1000;
	    	theo_yield = theo_yield / pack_size;

			$(this).closest('div.content').find('input[id=theo_yield]').val(parseFloat(theo_yield).toFixed(3));

			$($(this).closest('div.content').find('input[id=theo_yield]')).priceFormat({
			    centsLimit: 3,
			    prefix: "",
			    thousandsSeparator: ",",
			    clearOnEmpty: true,
			    allowNegative: false
			});

		});



	    $(".pack_size_unit").keyup(function() {
			$(this).closest('div.content').find('input[id=theo_yield_unit]').val($(this).val());
		});

	    $(".pack_size_unit").keydown(function() {
			$(this).closest('div.content').find('input[id=theo_yield_unit]').val($(this).val());
		});

	</script>

@endsection



