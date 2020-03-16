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
						        	<input type="hidden" name="batch_size" id="batch_size" value="{{ $jobOrder[$key]['batch_size'] }}">
						        	<input type="hidden" name="batch_size_unit" id="batch_size_unit" value="{{ $jobOrder[$key]['batch_size_unit'] }}">
						        	<input type="hidden" name="item_type_percent" id="item_type_percent" value="{{ $po_item->item_type_percent }}">
						        	<input type="hidden" name="unit_type_id" id="unit_type_id" value="{{ $po_item->unit_type_id }}">

					                {!! __form::textbox(
					                  '6', '', 'text', 'Reference PO Number', 'PO Number', $jobOrder[$key]['po_no'], '', '', 'readonly'
					                ) !!}  

					                {!! __form::textbox(
					                  '6', '', 'text', 'JO Number', 'JO Number', $jobOrder[$key]['jo_no'], '', '', 'readonly'
					                ) !!} 

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

					                {!! __form::textbox(
					                  '6', '', 'text', 'Batch Size', 'Batch Size', number_format($jobOrder[$key]['batch_size'], 3) .' '. $jobOrder[$key]['batch_size_unit'], '', '', 'readonly'
					                ) !!}  

		                            <div class="form-group col-md-6">
						              <label for="lot_no">Lot No.</label>
		                              <input type="text" name="row[{{ $key }}][lot_no]" id="lot_no" class="form-control lot_no" placeholder="Lot No." value="{{ $data['lot_no'] }}">
						              <small class="text-danger">{{ $errors->first('row.'. $key .'.lot_no') }}</small>
		                            </div>

		                            <div class="form-group col-md-6">
						              <label for="pack_size">Pack Size</label>
		                              <input type="text" name="row[{{ $key }}][pack_size]" id="pack_size" class="form-control pack_size" placeholder="Pack Size" value="{{ $data['pack_size'] }}">
						              <small class="text-danger">{{ $errors->first('row.'. $key .'.pack_size') }}</small>
		                            </div>

		                            <div class="form-group col-md-3">
						              <label for="pack_size_pkging">Pack Size Unit</label>
		                              <select name="row[{{ $key }}][pack_size_unit]"  id="pack_size_unit" class="form-control pack_size_unit">
		                                @foreach($unit_type_list as $key_unit => $data_unit)
		                                  <option value="{{ $key_unit }}" {!! $data['pack_size_unit'] == $key_unit ? 'selected' : ''!!}>{{ $data_unit }}</option>
		                                @endforeach
		                              </select>
		                            </div>

		                            <div class="form-group col-md-3">
						              <label for="pack_size_pkging">Pack Size Pkging</label>
		                              <input type="text" name="row[{{ $key }}][pack_size_pkging]" id="pack_size_pkging" class="form-control pack_size_pkging" placeholder="Pack Size Pkging" value="{{ $data['pack_size_pkging'] }}">
						              <small class="text-danger">{{ $errors->first('row.'. $key .'.pack_size_pkging') }}</small>
		                            </div>

					                <div class="col-md-12"></div>

		                            <div class="form-group col-md-6">
						              <label for="theo_yield">Theoritical Yield</label>
		                              <input type="text" name="row[{{ $key }}][theo_yield]" id="theo_yield" class="form-control theo_yield" placeholder="Theoritical Yield" value="{{ $data['theo_yield'] }}" readonly="readonly">
						              <small class="text-danger">{{ $errors->first('row.'. $key .'.theo_yield') }}</small>
		                            </div>

		                            <div class="form-group col-md-6">
						              <label for="theo_yield_pkging">Theoritical Yield Pkging</label>
		                              <input type="text" name="row[{{ $key }}][theo_yield_pkging]" id="theo_yield_pkging" class="form-control theo_yield_pkging" placeholder="Theoritical Yield Pkging" value="{{ $data['theo_yield_pkging'] }}" readonly="readonly">
						              <small class="text-danger">{{ $errors->first('row.'. $key .'.theo_yield_pkging') }}</small>
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
						                  <input id="date" name="row[{{ $key }}][date]" value="{{ __dataType::date_parse($data->date, 'm/d/Y') }}" type="text" class="form-control datepicker date" placeholder="mm/dd/yy">
						                </div>
					              	</div>

					                {!! __form::textbox(
					                  '6', '', 'text', 'Qty Required', 'Qty Required', number_format($data->amount, 3) .' '. $data->unit, '', '', 'readonly'
					                ) !!}	

					                <div class="col-md-12"></div>

					                {!! __form::textbox(
					                  '6', '', 'text', 'Batch Size', 'Batch Size', number_format($data->batch_size, 3) .' '. $data->batch_size_unit, '', '', 'readonly'
					                ) !!}  

		                            <div class="form-group col-md-6">
						              <label for="lot_no">Lot No.</label>
		                              <input type="text" name="row[{{ $key }}][lot_no]" id="lot_no" class="form-control lot_no" placeholder="Lot No." value="{{ $data->lot_no }}">
		                            </div>

		                            <div class="form-group col-md-6">
						              <label for="pack_size">Pack Size</label>
		                              <input type="text" name="row[{{ $key }}][pack_size]" id="pack_size" class="form-control pack_size" placeholder="Pack Size" value="{{ $data->pack_size }}">
		                            </div>

		                            <div class="form-group col-md-3">
						              <label for="pack_size_pkging">Pack Size Unit</label>
		                              <select name="row[{{ $key }}][pack_size_unit]"  id="pack_size_unit" class="form-control pack_size_unit">
		                                @foreach($unit_type_list as $key_unit => $data_unit)
		                                  <option value="{{ $key_unit }}" {!! $data->pack_size_unit == $key_unit ? 'selected' : ''!!}>{{ $data_unit }}</option>
		                                @endforeach
		                              </select>
		                            </div>

		                            <div class="form-group col-md-3">
						              <label for="pack_size_pkging">Pack Size Pkging</label>
		                              <input type="text" name="row[{{ $key }}][pack_size_pkging]" id="pack_size_pkging" class="form-control pack_size_pkging" placeholder="Pack Size Pkging" value="{{ $data->pack_size_pkging }}">
		                            </div>

						            <div class="col-md-12"></div>

		                            <div class="form-group col-md-6">
						              <label for="theo_yield">Theoritical Yield</label>
		                              <input type="text" name="row[{{ $key }}][theo_yield]" id="theo_yield" class="form-control theo_yield" placeholder="Theoritical Yield" value="{{ $data->theo_yield }}" readonly="readonly">
		                            </div>

		                            <div class="form-group col-md-6">
						              <label for="theo_yield_pkging">Theoritical Yield Pkging</label>
		                              <input type="text" name="row[{{ $key }}][theo_yield_pkging]" id="theo_yield_pkging" class="form-control theo_yield_pkging" placeholder="Theoritical Yield Pkging" value="{{ $data->theo_yield_pkging }}" readonly="readonly">
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


		function convert(unit_type_id, from_unit, to_unit, amount) {
		   	converted_amount = amount;
			if(unit_type_id != 'IU1001'){
				if(from_unit == 'KILOGRAM' && to_unit == 'GRAM'){
					converted_amount = amount * 1000;
				}else if(from_unit == 'GRAM' && to_unit == 'KILOGRAM'){
					converted_amount = amount / 1000;
				}else if(from_unit == 'LITRE' && to_unit == 'MILLILITRE'){
					converted_amount = amount * 1000;
				}else if(from_unit == 'MILLILITRE' && to_unit == 'LITRE'){
					converted_amount = amount / 1000;
				}else{
					converted_amount = amount;
				}
			}
			return converted_amount;
		}
	

		$('.pack_size').priceFormat({
		    centsLimit: 3,
		    prefix: "",
		    thousandsSeparator: ",",
		    clearOnEmpty: true,
		    allowNegative: false
		});
	

		$('.theo_yield').priceFormat({
		    centsLimit: 3,
		    prefix: "",
		    thousandsSeparator: ",",
		    clearOnEmpty: true,
		    allowNegative: false
		});


	    $(".pack_size").keyup(function() {

	    	pack_size = $(this).val();
	    	pack_size_unit = $(this).closest('div.content').find('input[id=pack_size_unit]').val();
	    	batch_size = $(this).closest('div.content').find('input[id=batch_size]').val();
	    	batch_size_unit = $(this).closest('div.content').find('input[id=batch_size_unit]').val();
	    	percent = $(this).closest('div.content').find('input[id=item_type_percent]').val() / 100;
	    	unit_type_id = $(this).closest('div.content').find('input[id=unit_type_id]').val();
	    	
	    	pack_size = parseFloat(pack_size);
	    	batch_size = parseFloat(batch_size);
	    	percent = parseFloat(percent);

	    	theo_yield = batch_size * percent;
	    	theo_yield = convert(unit_type_id, batch_size_unit, pack_size_unit, theo_yield);
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
	    	theo_yield = convert(unit_type_id, batch_size_unit, pack_size_unit, theo_yield);
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


	    $(".pack_size_pkging").keyup(function() {
			$(this).closest('div.content').find('input[id=theo_yield_pkging]').val($(this).val());
		});

	    $(".pack_size_pkging").keydown(function() {
			$(this).closest('div.content').find('input[id=theo_yield_pkging]').val($(this).val());
		});

	</script>

@endsection



