@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title" style="padding-top: 5px;">Fill Finishing Order</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
            &nbsp;
            {!! __html::back_button(['dashboard.finishing_order.index']) !!}
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.finishing_order.fill_up_post', $finishing_order->slug) }}">

        <div class="box-body">

          <div class="col-md-12">

            @csrf

            {!! __form::textbox('3', '', 'text', 'Product', '', $finishing_order->item_name, '', '', 'readonly') !!}

            {!! __form::textbox('3', '', 'text', 'Lot No.', '', $finishing_order->lot_no, '', '', 'readonly') !!}

            {!! __form::textbox(
              '3', 'master_fo_no', 'text', 'Master FO No. *', 'Master FO No.', old('master_fo_no') ? old('master_fo_no') : $finishing_order->master_fo_no, $errors->has('master_fo_no'), $errors->first('master_fo_no'), ''
            ) !!}

            {!! __form::textbox(
              '3', 'fo_no', 'text', 'FO No. *', 'FO No.', old('fo_no') ? old('fo_no') : $finishing_order->fo_no, $errors->has('fo_no'), $errors->first('fo_no'), ''
            ) !!}

            <div class="col-md-12"></div>            

            {!! __form::textbox('3', '', 'text', 'Product Form', '', optional($finishing_order->itemType)->name, '', '', 'readonly') !!}

            {!! __form::textbox('3', '', 'text', 'Product Code', '', $finishing_order->item_product_code, '', '', 'readonly') !!}

            {!! __form::textbox(
              '3', '', 'text', 'Batch Size', '', number_format($finishing_order->jo_batch_size, 3).' '. $finishing_order->jo_batch_size_unit, '', '', 'readonly'
            ) !!}

            {!! __form::textbox(
              '3', '', 'text', 'JO No.', '', $finishing_order->jo_no, '', '', 'readonly'
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
              '3', 'client', 'text', 'Client *', 'Client', old('client') ? old('client') : $finishing_order->client, $errors->has('client'), $errors->first('client'), ''
            ) !!}

            {!! __form::textbox(
              '3', 'shell_life', 'text', 'Shell Life *', 'Shell Life', old('shell_life') ? old('shell_life') : $finishing_order->shell_life, $errors->has('shell_life'), $errors->first('shell_life'), ''
            ) !!}

            {!! __form::textbox(
              '3', '', 'text', 'Pack Size', '', number_format($finishing_order->jo_pack_size, 3) .' '. $finishing_order->jo_pack_size_unit .' per '. $finishing_order->jo_pack_size_pkging, '', '', 'readonly'
            ) !!}

            {!! __form::textbox('3', '', 'text', 'PO No.', '', $finishing_order->po_no, '', '', 'readonly') !!}

            <div class="col-md-12"></div>

            {!! __form::datepicker(
              '4', 'processing_date',  'Processing Date *', old('processing_date') ? old('processing_date') : $finishing_order->processing_date, $errors->has('processing_date'), $errors->first('processing_date')
            ) !!}

            {!! __form::datepicker(
              '4', 'expired_date',  'Expired Date *', old('expired_date') ? old('expired_date') : $finishing_order->expired_date, $errors->has('expired_date'), $errors->first('expired_date')
            ) !!}

            {!! __form::textbox(
              '4', '', 'text', 'Theoritical Yield', '', number_format($finishing_order->jo_theo_yield, 3).' '. $finishing_order->jo_theo_yield_pkging, '', '', 'readonly'
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::datepicker(
              '4', 'requested_date',  'Requested Date *', old('requested_date') ? old('requested_date') : $finishing_order->requested_date, $errors->has('requested_date'), $errors->first('requested_date')
            ) !!}

            {!! __form::textbox(
              '4', 'requested_by', 'text', 'Requested By *', 'Requested By', old('requested_by') ? old('requested_by') : $finishing_order->requested_by, $errors->has('requested_by'), $errors->first('requested_by'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'status', 'text', 'Status *', 'Status', old('status') ? old('status') : $finishing_order->status, $errors->has('status'), $errors->first('status'), ''
            ) !!}

          </div>




          {{-- 1st Table --}}
          <div class="col-md-12" style="padding:30px;">
            
            <h4>Packaging Materials</h4>
            <table class="table table-bordered">

              <tr>
                <th style="width:150px">Code</th>
                <th style="width:200px">Packaging Materials</th>
                <th>Description</th>
                <th>Required Qty</th>
                <th>Unit</th>
                <th>Issued Qty</th>
                <th>Unit</th>
              </tr>

              <tbody id="table_body">

                @if(old('row'))
                  @foreach(old('row') as $key => $value)
                    <?php
                      $unit_type_list = [];
                      if ($value['unit_type_id'] == 'IU1001') {
                        $unit_type_list = ['PCS' => 'PCS', ];
                      }elseif ($value['unit_type_id'] == 'IU1002') {
                        $unit_type_list = ['GRAM' => 'GRAM'];
                      }elseif ($value['unit_type_id'] == 'IU1003') {
                        $unit_type_list = ['MILLILITRE' => 'MILLILITRE'];
                      }
                    ?>

                    <tr>

                      <input type="hidden" name="row[{{ $key }}][fo_pack_mat_id]" value="{{ $value['fo_pack_mat_id'] }}">
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
                          <input type="text" name="row[{{ $key }}][item_description]" class="form-control" value="{{ $value['item_description'] }}" readonly>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row[{{ $key }}][req_qty]" class="form-control num" placeholder="Required Quantity" value="{{ $value['req_qty'] }}">
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
                          <input type="text" name="row[{{ $key }}][qty_issued]" class="form-control num" placeholder="Quantity Issued" value="{{ $value['qty_issued'] }}">
                          <small class="text-danger">{{ $errors->first('row.'. $key .'.qty_issued') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <select name="row[{{ $key }}][qty_issued_unit]" class="form-control">
                            @foreach($unit_type_list as $key_unit => $data_unit)
                              <option value="{{ $key_unit }}" {!! $value['qty_issued_unit'] == $key_unit ? 'selected' : ''!!}>{{ $data_unit }}</option>
                            @endforeach
                          </select>
                        </div>
                      </td>

                    </tr>

                  @endforeach

              @else

                @foreach($finishing_order->finishingOrderPackMat as $key => $data)

                    <?php
                      $unit_type_list = [];
                      if ($data->unit_type_id == 'IU1001') {
                        $unit_type_list = ['PCS' => 'PCS', ];
                      }elseif ($data->unit_type_id == 'IU1002') {
                        $unit_type_list = ['GRAM' => 'GRAM',];
                      }elseif ($data->unit_type_id == 'IU1003') {
                        $unit_type_list = ['MILLILITRE' => 'MILLILITRE',];
                      }
                    ?>

                    <tr>
                      
                        <input type="hidden" name="row[{{ $key }}][fo_pack_mat_id]" value="{{ $data->fo_pack_mat_id }}">
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
                          <input type="text" name="row[{{ $key }}][item_description]" class="form-control" value="{{ $data->item_description }}" readonly>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row[{{ $key }}][req_qty]" class="form-control num" placeholder="Required Quantity" value="{{ $data->req_qty }}">
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
                          <input type="text" name="row[{{ $key }}][qty_issued]" class="form-control num" placeholder="Required Quantity" value="{{ $data->qty_issued }}">
                          <small class="text-danger">{{ $errors->first('row.'. $key .'.qty_issued') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <select name="row[{{ $key }}][qty_issued_unit]" class="form-control">
                            @foreach($unit_type_list as $key_unit => $data_unit)
                              <option value="{{ $key_unit }}" {!! $data->qty_issued_unit == $key_unit ? 'selected' : ''!!}>{{ $data_unit }}</option>
                            @endforeach
                          </select>
                        </div>
                      </td>

                  </tr>

                @endforeach

                @endif

              </tbody>
            </table>

          </div>




          {{-- 2nd Table --}}
          <div class="col-md-12" style="padding:30px; margin-top:-30px;">
            
            <h4>Figures</h4>
            <table class="table table-bordered">

              <tr>
                <th style="width:150px">Unit</th>
                <th>Actual Usage</th>
                <th>Rejected</th>
                <th>Damaged</th>
                <th>Returns</th>
                <th>Samples</th>
                <th>Total</th>
                <th>Difference</th>
              </tr>

              <tbody id="table_body">

                @if(old('row_figure'))
                  @foreach(old('row_figure') as $key_figure => $value_figure)
                    <?php
                      $unit_type_list = [];
                      if ($value['unit_type_id'] == 'IU1001') {
                        $unit_type_list = ['PCS' => 'PCS', ];
                      }elseif ($value['unit_type_id'] == 'IU1002') {
                        $unit_type_list = ['GRAM' => 'GRAM'];
                      }elseif ($value['unit_type_id'] == 'IU1003') {
                        $unit_type_list = ['MILLILITRE' => 'MILLILITRE'];
                      }
                    ?>

                    <tr>

                      <input type="hidden" name="row_figure[{{ $key_figure }}][fo_pack_mat_id]" value="{{ $value_figure['fo_pack_mat_id'] }}">
                      <input type="hidden" name="row_figure[{{ $key_figure }}][unit_type_id]" value="{{ $value_figure['unit_type_id'] }}">

                      <td>
                        <div class="form-group">
                          <select name="row_figure[{{ $key_figure }}][figure_unit]" class="form-control">
                            @foreach($unit_type_list as $key_unit => $data_unit)
                              <option value="{{ $key_unit }}" {!! $value_figure['figure_unit'] == $key_unit ? 'selected' : ''!!}>{{ $data_unit }}</option>
                            @endforeach
                          </select>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row_figure[{{ $key_figure }}][figure_actual_usage]" class="form-control num" placeholder="Actual Usage" value="{{ $value_figure['figure_actual_usage'] }}">
                          <small class="text-danger">{{ $errors->first('row_figure.'. $key_figure .'.figure_actual_usage') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row_figure[{{ $key_figure }}][figure_regected]" class="form-control num" placeholder="Regected" value="{{ $value_figure['figure_regected'] }}">
                          <small class="text-danger">{{ $errors->first('row_figure.'. $key_figure .'.figure_regected') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row_figure[{{ $key_figure }}][figure_damaged]" class="form-control num" placeholder="Damaged" value="{{ $value_figure['figure_damaged'] }}">
                          <small class="text-danger">{{ $errors->first('row_figure.'. $key_figure .'.figure_damaged') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row_figure[{{ $key_figure }}][figure_returns]" class="form-control num" placeholder="Returns" value="{{ $value_figure['figure_returns'] }}">
                          <small class="text-danger">{{ $errors->first('row_figure.'. $key_figure .'.figure_returns') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row_figure[{{ $key_figure }}][figure_samples]" class="form-control num" placeholder="Samples" value="{{ $value_figure['figure_samples'] }}">
                          <small class="text-danger">{{ $errors->first('row_figure.'. $key_figure .'.figure_samples') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row_figure[{{ $key_figure }}][figure_total]" class="form-control num" placeholder="Total" value="{{ $value_figure['figure_total'] }}">
                          <small class="text-danger">{{ $errors->first('row_figure.'. $key_figure .'.figure_total') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row_figure[{{ $key_figure }}][figure_difference]" class="form-control num" placeholder="Difference" value="{{ $value_figure['figure_difference'] }}">
                          <small class="text-danger">{{ $errors->first('row_figure.'. $key_figure .'.figure_difference') }}</small>
                        </div>
                      </td>

                    </tr>

                  @endforeach

              @else

                @foreach($finishing_order->finishingOrderPackMat as $key_figure => $data_figure)

                    <?php
                      $unit_type_list = [];
                      if ($data_figure->unit_type_id == 'IU1001') {
                        $unit_type_list = ['PCS' => 'PCS', ];
                      }elseif ($data_figure->unit_type_id == 'IU1002') {
                        $unit_type_list = ['GRAM' => 'GRAM',];
                      }elseif ($data_figure->unit_type_id == 'IU1003') {
                        $unit_type_list = ['MILLILITRE' => 'MILLILITRE',];
                      }
                    ?>

                    <tr>
                    
                      <input type="hidden" name="row_figure[{{ $key_figure }}][fo_pack_mat_id]" value="{{ $data_figure->fo_pack_mat_id }}">
                      <input type="hidden" name="row_figure[{{ $key_figure }}][unit_type_id]" value="{{ $data_figure->unit_type_id }}">

                      <td>
                        <div class="form-group">
                          <select name="row_figure[{{ $key_figure }}][figure_unit]" class="form-control">
                            @foreach($unit_type_list as $key_unit => $data_unit)
                              <option value="{{ $key_unit }}" {!! $data_figure->figure_unit == $key_unit ? 'selected' : ''!!}>{{ $data_unit }}</option>
                            @endforeach
                          </select>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row_figure[{{ $key_figure }}][figure_actual_usage]" class="form-control num" placeholder="Actual Usage" value="{{ $data_figure->figure_actual_usage }}">
                          <small class="text-danger">{{ $errors->first('row_figure.'. $key_figure .'.figure_actual_usage') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row_figure[{{ $key_figure }}][figure_regected]" class="form-control num" placeholder="Regected" value="{{ $data_figure->figure_regected }}">
                          <small class="text-danger">{{ $errors->first('row_figure.'. $key_figure .'.figure_regected') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row_figure[{{ $key_figure }}][figure_damaged]" class="form-control num" placeholder="Damaged" value="{{ $data_figure->figure_damaged }}">
                          <small class="text-danger">{{ $errors->first('row_figure.'. $key_figure .'.figure_damaged') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row_figure[{{ $key_figure }}][figure_returns]" class="form-control num" placeholder="Returns" value="{{ $data_figure->figure_returns }}">
                          <small class="text-danger">{{ $errors->first('row_figure.'. $key_figure .'.figure_returns') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row_figure[{{ $key_figure }}][figure_samples]" class="form-control num" placeholder="Samples" value="{{ $data_figure->figure_samples }}">
                          <small class="text-danger">{{ $errors->first('row_figure.'. $key_figure .'.figure_samples') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row_figure[{{ $key_figure }}][figure_total]" class="form-control num" placeholder="Total" value="{{ $data_figure->figure_total }}">
                          <small class="text-danger">{{ $errors->first('row_figure.'. $key_figure .'.figure_total') }}</small>
                        </div>
                      </td>

                      <td>
                        <div class="form-group">
                          <input type="text" name="row_figure[{{ $key_figure }}][figure_difference]" class="form-control num" placeholder="Difference" value="{{ $data_figure->figure_difference }}">
                          <small class="text-danger">{{ $errors->first('row_figure.'. $key_figure .'.figure_difference') }}</small>
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

  $('.num').priceFormat({
      centsLimit: 3,
      prefix: "",
      thousandsSeparator: ",",
      clearOnEmpty: true,
      allowNegative: false
  });

</script>

@endsection