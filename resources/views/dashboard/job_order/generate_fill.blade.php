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

<form data-pjax method="GET" autocomplete="off" action="{{ route('dashboard.job_order.create') }}">

    <div class="col-md-12">
	    <div class="box box-solid">
	      <div class="box-header with-border">
	        <h2 class="box-title">Fill JO Batches</h2>
	        <div class="pull-right">
	            <code>Fields with asterisks(*) are required</code>
	        </div> 
	      </div>

	        <div class="box-body">

	        	@foreach ($po_item->jobOrder as $key => $data)

	        		<div class="col-md-6" style="margin-bottom:20px;">
					    <div class="box">
					      <div class="box-header with-border">
					        <h2 class="box-title">#{{ $key + 1 }}</h2>
					      </div>
					        <div class="box-body">

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

						        {!! __form::datepicker(
						          '6', 'date_required',  'Date Required *', old('date_required'), $errors->has('date_required'), $errors->first('date_required')
						        ) !!}

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

				                {!! __form::textbox_numeric(
				                  '6', 'pack_size', 'text', 'Pack Size', 'Pack Size', old('pack_size') ? old('pack_size') : $data->pack_size, $errors->has('pack_size'), $errors->first('pack_size'), ''
				                ) !!}

						        {!! __form::select_static(
						          '6', 'pack_size_unit', 'Pack Size Unit', old('pack_size_unit'), $unit_type_list, $errors->has('pack_size_unit'), $errors->first('pack_size_unit'), '', ''
						        ) !!}

				                {!! __form::textbox_numeric(
				                  '6', 'theo_yield', 'text', 'Theoritical Yield', 'Theoritical Yield', old('theo_yield') ? old('theo_yield') : $data->theo_yield, $errors->has('theo_yield'), $errors->first('theo_yield'), 'readonly'
				                ) !!}

						        {!! __form::select_static(
						          '6', 'theo_yield', 'Theoritical Yield Unit', old('theo_yield'), $unit_type_list, $errors->has('theo_yield'), $errors->first('theo_yield'), '', 'readonly'
						        ) !!}

					        </div>
					    </div>	
	        		</div>

			    @endforeach


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
	
      $('#pack_size').priceFormat({
          centsLimit: 3,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });
	
      $('#theo_yield').priceFormat({
          centsLimit: 3,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });

	</script>

@endsection



