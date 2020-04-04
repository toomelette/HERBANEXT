@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title" style="padding-top: 5px;">Fill Manufacturing Order</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
            &nbsp;
            {!! __html::back_button(['dashboard.item_type.index']) !!}
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.manufacturing_order.fill_up_post', $manufacturing_order->slug) }}">

        <div class="box-body">

          <div class="col-md-12">

            @csrf

            {!! __form::textbox('3', '', 'text', 'Product', '', $manufacturing_order->item_name, '', '', 'readonly') !!}

            {!! __form::textbox('3', '', 'text', 'Lot No.', '', $manufacturing_order->lot_no, '', '', 'readonly') !!}

            {!! __form::textbox(
              '3', 'master_mo_no', 'text', 'Master MO No. *', 'Master MO No.', old('master_mo_no') ? old('master_mo_no') : $manufacturing_order->master_mo_no, $errors->has('master_mo_no'), $errors->first('master_mo_no'), ''
            ) !!}

            {!! __form::textbox(
              '3', 'mo_no', 'text', 'MO No. *', 'MO No.', old('mo_no') ? old('mo_no') : $manufacturing_order->mo_no, $errors->has('mo_no'), $errors->first('mo_no'), ''
            ) !!}

            <div class="col-md-12"></div>            

            {!! __form::textbox('3', '', 'text', 'Product Form', '', optional($manufacturing_order->itemType)->name, '', '', 'readonly') !!}

            {!! __form::textbox('3', '', 'text', 'Product Code', '', $manufacturing_order->item_product_code, '', '', 'readonly') !!}

            {!! __form::textbox(
              '3', '', 'text', 'Batch Size', '', number_format($manufacturing_order->jo_batch_size, 3).' '. $manufacturing_order->jo_batch_size_unit, '', '', 'readonly'
            ) !!}

            {!! __form::textbox(
              '3', '', 'text', 'JO No.', '', $manufacturing_order->jo_no, '', '', 'readonly'
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
              '3', 'client', 'text', 'Client *', 'Client', old('client') ? old('client') : $manufacturing_order->client, $errors->has('client'), $errors->first('client'), ''
            ) !!}

            {!! __form::textbox(
              '3', 'shell_life', 'text', 'Shell Life *', 'Shell Life', old('shell_life') ? old('shell_life') : $manufacturing_order->shell_life, $errors->has('shell_life'), $errors->first('shell_life'), ''
            ) !!}

            {!! __form::textbox(
              '3', '', 'text', 'Pack Size', '', number_format($manufacturing_order->jo_pack_size, 3) .' '. $manufacturing_order->jo_pack_size_unit .' per '. $manufacturing_order->jo_pack_size_pkging, '', '', 'readonly'
            ) !!}

            {!! __form::textbox('3', '', 'text', 'PO No.', '', $manufacturing_order->po_no, '', '', 'readonly') !!}

            <div class="col-md-12"></div>

            {!! __form::datepicker(
              '4', 'processing_date',  'Processing Date *', old('processing_date') ? old('processing_date') : $manufacturing_order->processing_date, $errors->has('processing_date'), $errors->first('processing_date')
            ) !!}

            {!! __form::datepicker(
              '4', 'expired_date',  'Expired Date *', old('expired_date') ? old('expired_date') : $manufacturing_order->expired_date, $errors->has('expired_date'), $errors->first('expired_date')
            ) !!}

            {!! __form::textbox(
              '4', '', 'text', 'Theoritical Yield', '', number_format($manufacturing_order->jo_theo_yield, 3).' '. $manufacturing_order->jo_theo_yield_pkging, '', '', 'readonly'
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::datepicker(
              '4', 'requested_date',  'Requested Date *', old('requested_date') ? old('requested_date') : $manufacturing_order->requested_date, $errors->has('requested_date'), $errors->first('requested_date')
            ) !!}

            {!! __form::textbox(
              '4', 'requested_by', 'text', 'Requested By *', 'Requested By', old('requested_by') ? old('requested_by') : $manufacturing_order->requested_by, $errors->has('requested_by'), $errors->first('requested_by'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'status', 'text', 'Status *', 'Status', old('status') ? old('status') : $manufacturing_order->status, $errors->has('status'), $errors->first('status'), ''
            ) !!}

          </div>

          <div class="col-md-12" style="padding:30px;">
            
            <h4>Raw Materials</h4>

            <table class="table table-bordered">

              <tr>
                <th>Code</th>
                <th>Raw Materials</th>
                <th>Required Quantity</th>
                <th>Unit</th>
                <th>Batch No.</th>
                <th>Weighed by/Date</th>
              </tr>

              <tbody id="table_body">

                @if(old('row'))
                  @foreach(old('row') as $key => $value)
                    <?php
                      $unit_type_list = [];
                      if ($value['unit_type_id'] == 'IU1001') {
                        $unit_type_list = ['PCS' => 'PCS', ];
                      }elseif ($value['unit_type_id'] == 'IU1002') {
                        $unit_type_list = ['GRAM' => 'GRAM', 'KILOGRAM' => 'KILOGRAM'];
                      }elseif ($value['unit_type_id'] == 'IU1003') {
                        $unit_type_list = ['MILLILITRE' => 'MILLILITRE', 'LITRE' => 'LITRE'];
                      }
                    ?>

                    <tr>

                      <input type="hidden" name="row[{{ $key }}][mo_raw_mat_id]" value="{{ $value['mo_raw_mat_id'] }}">
                      <input type="hidden" name="row[{{ $key }}][unit_type_id]" value="{{ $value['unit_type_id'] }}">

                      <td>
                        <div class="form-group">
                          <input type="text" name="row[{{ $key }}][item_product_code]" class="form-control" value="{{ $value['item_product_code'] }}" readonly>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row[{{ $key }}][item_name]" class="form-control" value="{{ $value['item_name'] }}" readonly>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row[{{ $key }}][req_qty]" class="form-control req_qty" placeholder="Required Quantity" value="{{ $value['req_qty'] }}">
                          <small class="text-danger">{{ $errors->first('row.'. $key .'.req_qty') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <select name="row[{{ $key }}][req_qty_unit]" class="form-control">
                            @foreach($unit_type_list as $key_unit => $data_unit)
                              <option value="{{ $key_unit }}" {!! $value['req_qty_unit'] == $key_unit ? 'selected' : ''!!}>{{ $data_unit }}</option>
                            @endforeach
                          </select>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row[{{ $key }}][batch_no]" class="form-control" placeholder="Batch No." value="{{ $value['batch_no'] }}">
                          <small class="text-danger">{{ $errors->first('row.'. $key .'.batch_no') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row[{{ $key }}][weighed_by]" class="form-control" placeholder="Weighed By" value="{{ $value['weighed_by'] }}">
                          <small class="text-danger">{{ $errors->first('row.'. $key .'.weighed_by') }}</small>
                        </div>
                      </td>

                    </tr>

                  @endforeach

              @else

                @foreach($manufacturing_order->manufacturingOrderRawMat as $key => $data)

                    <?php
                      $unit_type_list = [];
                      if ($data->unit_type_id == 'IU1001') {
                        $unit_type_list = ['PCS' => 'PCS', ];
                      }elseif ($data->unit_type_id == 'IU1002') {
                        $unit_type_list = ['GRAM' => 'GRAM', 'KILOGRAM' => 'KILOGRAM'];
                      }elseif ($data->unit_type_id == 'IU1003') {
                        $unit_type_list = ['MILLILITRE' => 'MILLILITRE', 'LITRE' => 'LITRE'];
                      }
                    ?>

                    <tr>
                      
                      <input type="hidden" name="row[{{ $key }}][mo_raw_mat_id]" value="{{ $data->mo_raw_mat_id }}">
                      <input type="hidden" name="row[{{ $key }}][unit_type_id]" value="{{ $data->unit_type_id }}">

                      <td>
                        <div class="form-group">
                          <input type="text" name="row[{{ $key }}][item_product_code]" class="form-control" value="{{ $data->item_product_code }}" readonly>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row[{{ $key }}][item_name]" class="form-control" value="{{ $data->item_name }}" readonly>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row[{{ $key }}][req_qty]" class="form-control req_qty" placeholder="Required Quantity" value="{{ $data->req_qty }}">
                          <small class="text-danger">{{ $errors->first('row.'. $key .'.req_qty') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <select name="row[{{ $key }}][req_qty_unit]" class="form-control">
                            @foreach($unit_type_list as $key_unit => $data_unit)
                              <option value="{{ $key_unit }}" {!! $data->req_qty_unit == $key_unit ? 'selected' : ''!!}>{{ $data_unit }}</option>
                            @endforeach
                          </select>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row[{{ $key }}][batch_no]" class="form-control" placeholder="Batch No." value="{{ $data->batch_no }}">
                          <small class="text-danger">{{ $errors->first('row.'. $key .'.batch_no') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row[{{ $key }}][weighed_by]" class="form-control" placeholder="Weighed By" value="{{ $data->weighed_by }}">
                          <small class="text-danger">{{ $errors->first('row.'. $key .'.weighed_by') }}</small>
                        </div>
                      </td>

                  </tr>

                @endforeach

                @endif

              </tbody>
            </table>

          </div>

        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-default">Save <i class="fa fa-fw fa-save"></i></button>
        </div>

      </form>

    </div>

</section>

@endsection



@section('scripts')

<script type="text/javascript">

    $('.req_qty').priceFormat({
        centsLimit: 3,
        prefix: "",
        thousandsSeparator: ",",
        clearOnEmpty: true,
        allowNegative: false
    });

</script>

@endsection