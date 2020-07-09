<?php
  
  $batch_type_units = [

    'PCS' => 'PCS',
    'GRAMS' => 'GRAM',
    'KILOGRAMS' => 'KILOGRAM',
    'MILLILITERS' => 'MILLILITRE',
    'LITERS' => 'LITRE',

  ];

?>

@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">New Item</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.item.store') }}">

        <div class="box-body">


          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Info</h3>
              </div>
              <div class="box-body">
                  
              @csrf    

              {!! __form::textbox(
                '6', 'product_code', 'text', 'Product Code *', 'Product Code', old('product_code'), $errors->has('product_code'), $errors->first('product_code'), ''
              ) !!}

              {!! __form::select_dynamic(
                '6', 'supplier_id', 'Supplier *', old('supplier_id'), $global_suppliers_all, 'supplier_id', 'name', $errors->has('supplier_id'), $errors->first('supplier_id'), 'select2', ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::select_dynamic(
                '6', 'item_category_id', 'Category *', old('item_category_id'), $global_item_categories_all, 'item_category_id', 'name', $errors->has('item_category_id'), $errors->first('item_category_id'), 'select2', ''
              ) !!}

              {!! __form::select_dynamic(
                '6', 'item_type_id', 'Type *', old('item_type_id'), $global_item_types_all, 'item_type_id', 'name', $errors->has('item_type_id'), $errors->first('item_type_id'), 'select2', ''
              ) !!}

              {!! __form::textbox(
                '12', 'name', 'text', 'Name *', 'Name', old('name'), $errors->has('name'), $errors->first('name'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox(
                '12', 'description', 'text', 'Description', 'Description', old('description'), $errors->has('description'), $errors->first('description'), ''
              ) !!}

              </div>
            </div>
          </div>


          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Figures</h3>
              </div>
              <div class="box-body">

                {!! __form::select_static(
                  '12', 'unit_type_id', 'Unit Type *', old('unit_type_id'), ['BY QUANTITY' => 'IU1001', 'BY WEIGHT' => 'IU1002', 'BY VOLUME' => 'IU1003'], $errors->has('unit_type_id'), $errors->first('unit_type_id'), '', ''
                ) !!}

                {!! __form::textbox_numeric(
                  '6', 'beginning_balance', 'text', 'Beginning Balance *', 'Beginning Balance *', old('beginning_balance'), $errors->has('beginning_balance'), $errors->first('beginning_balance'), ''
                ) !!}

                {!! __form::select_static(
                  '6', 'unit', 'Standard Unit *', old('unit'), [], $errors->has('unit'), $errors->first('unit'), '', ''
                ) !!}

                <div class="col-md-12"></div>
                
                {!! __form::textbox_numeric(
                  '12', 'batch_size', 'text', 'Standard Batch Size', 'Standard Batch Size', old('batch_size'), $errors->has('batch_size'), $errors->first('batch_size'), ''
                ) !!}

                <div class="col-md-12"></div>

                {!! __form::textbox_numeric(
                  '6', 'min_req_qty', 'text', 'Minimum Required Quantity *', 'Minimum Required Quantity', old('min_req_qty'), $errors->has('min_req_qty'), $errors->first('min_req_qty'), ''
                ) !!}

                {!! __form::textbox_numeric(
                  '6', 'price', 'text', 'Price', 'Price', old('price'), $errors->has('price'), $errors->first('price'), ''
                ) !!}

              </div>
            </div>
          </div>


          <div class="col-md-12"></div>


          {{-- Raw Materials --}}
          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Raw Materials</h3>
                <button id="add_row_raw" type="button" class="btn btn-sm bg-green pull-right">Add New &nbsp;<i class="fa fw fa-plus"></i></button>
              </div>
              
              <div class="box-body no-padding">
                
                <table class="table table-bordered">

                  <tr>
                    <th>Item *</th>
                    <th style="width:300px;">Current Inventory</th>
                    <th style="width:40px;"></th>
                  </tr>

                  <tbody id="table_body_raw">

                    @if(old('row_raw'))
                      
                      @foreach(old('row_raw') as $key_raw => $value_raw)

                        <tr>

                          <td>
                            <select name="row_raw[{{ $key_raw }}][item]" id="item_raw" class="form-control item_raw">
                              <option value="">Select</option>
                              @foreach($global_items_all as $data) 
                                  <option value="{{ $data->item_id }}" {!! $value_raw['item'] == $data->item_id ? 'selected' : ''!!}>{{ $data->name }}</option>
                              @endforeach
                            </select>
                            <br><small class="text-danger">{{ $errors->first('row_raw.'. $key_raw .'.item') }}</small>
                          </td>

                          <td>
                            <div class="form-group col-md-6 no-padding">
                              <input type="text" name="row_raw[{{ $key_raw }}][remaining_balance]" id="remaining_balance" class="form-control remaining_balance" placeholder="Remaining Balance" value="{{ $value_raw['remaining_balance'] }}" readonly="readonly">
                              <small class="text-danger">{{ $errors->first('row_raw.'. $key_raw .'.remaining_balance') }}</small>
                            </div>
                            <div class="form-group col-md-6 no-padding">
                              <input type="text" name="row_raw[{{ $key_raw }}][remaining_balance_unit]" id="remaining_balance_unit" class="form-control remaining_balance_unit" placeholder="Unit" value="{{ $value_raw['remaining_balance_unit'] }}" readonly="readonly">
                              <small class="text-danger">{{ $errors->first('row_raw.'. $key_raw .'.remaining_balance_unit') }}</small>
                            </div>
                          </td>

                          <td>
                            <button id="delete_row" type="button" class="btn btn-sm bg-red"><i class="fa fa-times"></i></button>
                          </td>

                        </tr>

                      @endforeach

                    @endif

                    </tbody>
                </table>
               
              </div>

            </div>
          </div>


          {{-- Pack Materials --}}
          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Packaging Materials</h3>
                <button id="add_row_pack" type="button" class="btn btn-sm bg-green pull-right">Add New &nbsp;<i class="fa fw fa-plus"></i></button>
              </div>
              
              <div class="box-body no-padding">
                
                <table class="table table-bordered">

                  <tr>
                    <th>Item *</th>
                    <th style="width:300px;">Current Inventory</th>
                    <th style="width: 40px"></th>
                  </tr>

                  <tbody id="table_body_pack">

                    @if(old('row_pack'))
                      
                      @foreach(old('row_pack') as $key_pack => $value_pack)

                        <tr>

                          <td>
                            <select name="row_pack[{{ $key_pack }}][item]" id="item_pack" class="form-control item_pack">
                              <option value="">Select</option>
                              @foreach($global_items_all as $data) 
                                  <option value="{{ $data->item_id }}" {!! $value_pack['item'] == $data->item_id ? 'selected' : ''!!}>{{ $data->name }}</option>
                              @endforeach
                            </select>
                            <br><small class="text-danger">{{ $errors->first('row_pack.'. $key_pack .'.item') }}</small>
                          </td>

                          <td>
                            <div class="form-group col-md-6 no-padding">
                              <input type="text" name="row_pack[{{ $key_pack }}][remaining_balance]" id="remaining_balance" class="form-control remaining_balance" placeholder="Remaining Balance" value="{{ $value_pack['remaining_balance'] }}" readonly="readonly">
                              <small class="text-danger">{{ $errors->first('row_pack.'. $key_pack .'.remaining_balance') }}</small>
                            </div>
                            <div class="form-group col-md-6 no-padding">
                              <input type="text" name="row_pack[{{ $key_pack }}][remaining_balance_unit]" id="remaining_balance_unit" class="form-control remaining_balance_unit" placeholder="Unit" value="{{ $value_pack['remaining_balance_unit'] }}" readonly="readonly">
                              <small class="text-danger">{{ $errors->first('row_pack.'. $key_pack .'.remaining_balance_unit') }}</small>
                            </div>
                          </td>

                          <td>
                            <button id="delete_row" type="button" class="btn btn-sm bg-red"><i class="fa fa-times"></i></button>
                          </td>

                        </tr>

                      @endforeach

                    @endif

                    </tbody>
                </table>
               
              </div>

            </div>
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

    function textboxNumeric(id, dec){
      $(id).priceFormat({
          centsLimit: dec,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });
    }

    textboxNumeric("#price", 4);

    textboxNumeric(".remaining_balance", 3);

    @if(old('unit_type_id') == 'IU1001')

      $("#unit").empty();
      $("#unit").append("<option value='PCS'{{ old('unit') == 'PCS' ? 'selected' : '' }}>PCS</option>");

      textboxNumeric("#beginning_balance", 0);
      textboxNumeric("#min_req_qty", 0);

    @elseif(old('unit_type_id') == 'IU1002')

      $("#unit").empty();
      $("#unit").append("<option value>Select</option>");
      $("#unit").append("<option value='GRAM' {{ old('unit') == 'GRAM' ? 'selected' : '' }}>GRAMS</option>");
      $("#unit").append("<option value='KILOGRAM' {{ old('unit') == 'KILOGRAM' ? 'selected' : '' }}>KILOGRAMS</option>");

      textboxNumeric("#beginning_balance", 3);
      textboxNumeric("#min_req_qty", 3);

    @elseif(old('unit_type_id') == 'IU1003')

      $("#unit").empty();
      $("#unit").append("<option value>Select</option>");
      $("#unit").append("<option value='MILLILITRE' {{ old('unit') == 'MILLILITRE' ? 'selected' : '' }}>MILLILITERS</option>");
      $("#unit").append("<option value='LITRE' {{ old('unit') == 'LITRE' ? 'selected' : '' }}>LITERS</option>");

      textboxNumeric("#beginning_balance", 3);
      textboxNumeric("#min_req_qty", 3);

    @else

      $("#unit").empty();

      textboxNumeric("#beginning_balance", 0);
      textboxNumeric("#min_req_qty", 0);

    @endif



    $(document).on("change", "#unit_type_id", function () {

      var val = $(this).val();
      
      if(val == "IU1001"){ 

        $("#unit").empty();
        $("#unit").append("<option value='PCS'>PCS</option>");

        textboxNumeric("#beginning_balance", 0);
        textboxNumeric("#min_req_qty", 0);

      }else if(val == "IU1002"){

        $("#unit").empty();
        $("#unit").append("<option value>Select</option>");
        $("#unit").append("<option value='GRAM'>GRAMS</option>");
        $("#unit").append("<option value='KILOGRAM'>KILOGRAMS</option>");

        textboxNumeric("#beginning_balance", 3);
        textboxNumeric("#min_req_qty", 3);

      }else if(val == "IU1003"){

        $("#unit").empty();
        $("#unit").append("<option value>Select</option>");
        $("#unit").append("<option value='MILLILITRE'>MILLILITERS</option>");
        $("#unit").append("<option value='LITRE'>LITERS</option>");

        textboxNumeric("#beginning_balance", 3);
        textboxNumeric("#min_req_qty", 3);

      }else{

        $("#unit").empty();

        textboxNumeric("#beginning_balance", 0);
        textboxNumeric("#min_req_qty", 0);

      }

    });

    @if(Session::has('ITEM_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('ITEM_CREATE_SUCCESS')) !!}
    @endif



    {{-- ADD RAW Mats --}}
    $(document).ready(function() {
      $("#add_row_raw").on("click", function() {
          var i = $("#table_body_raw").children().length;
          $('.item_raw').select2('destroy');
          var content ='<tr>' +

                        '<td>' +
                          '<select name="row_raw[' + i + '][item]" id="item_raw" class="form-control item_raw">' +
                            '<option value="">Select</option>' +
                            '@foreach($global_items_all as $data)' +
                              '<option value="{{ $data->item_id }}">{{ $data->name }}</option>' +
                            '@endforeach' +
                          '</select>' +
                        '</td>' +

                        '<td>' +
                          '<div class="form-group col-md-6 no-padding">' +
                            '<input type="text" name="row_raw[' + i + '][remaining_balance]" id="remaining_balance" class="form-control remaining_balance" placeholder="Remaining Balance" readonly="readonly">' +
                          '</div>' +
                          '<div class="form-group col-md-6 no-padding" >' +
                            '<input type="text" name="row_raw[' + i + '][remaining_balance_unit]" id="remaining_balance_unit" class="form-control remaining_balance_unit" placeholder="Unit" readonly="readonly">' +
                          '</div>' +
                        '</td>' +

                        '<td>' +
                            '<button id="delete_row" type="button" class="btn btn-sm bg-red"><i class="fa fa-times"></i></button>' +
                        '</td>' +
                      '</tr>';

        $("#table_body_raw").append($(content));

        $('.item_raw').select2({
          dropdownParent: $('#table_body_raw')
        });

      });
    });




    $(document).ready(function() {
      $(document).on("change", "#item_raw", function() {
          var key = $(this).val();
          var parent = $(this).closest('tr');
          if(key) {
              $.ajax({
                  headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
                  url: "/api/item/select_item_byItemId/" + key,
                  type: "GET",
                  dataType: "json",
                  success:function(data) {  

                      $.each(data, function(key, value) {

                        $(parent).find(".remaining_balance").val(value.current_balance);
                        $(parent).find(".remaining_balance_unit").val(value.unit);

                        $(parent).find(".remaining_balance").priceFormat({
                            centsLimit: 3,
                            prefix: "",
                            thousandsSeparator: ",",
                            clearOnEmpty: true,
                            allowNegative: false
                        });

                      });
          
                  }
              });
          }else{
            $(parent).find(".remaining_balance").val('');
            $(parent).find(".remaining_balance_unit").val('');
          }
      });
    });




    {{-- ADD PACK Mats --}}
    $(document).ready(function() {
      $("#add_row_pack").on("click", function() {
          var i = $("#table_body_pack").children().length;
          $('.item_pack').select2('destroy');
          var content ='<tr>' +

                        '<td>' +
                          '<select name="row_pack[' + i + '][item]" id="item_pack" class="form-control item_pack">' +
                            '<option value="">Select</option>' +
                            '@foreach($global_items_all as $data)' +
                              '<option value="{{ $data->item_id }}">{{ $data->name }}</option>' +
                            '@endforeach' +
                          '</select>' +
                        '</td>' +

                        '<td>' +
                          '<div class="form-group col-md-6 no-padding">' +
                            '<input type="text" name="row_pack[' + i + '][remaining_balance]" id="remaining_balance" class="form-control remaining_balance" placeholder="Remaining Balance" readonly="readonly">' +
                          '</div>' +
                          '<div class="form-group col-md-6 no-padding" >' +
                            '<input type="text" name="row_pack[' + i + '][remaining_balance_unit]" id="remaining_balance_unit" class="form-control remaining_balance_unit" placeholder="Unit" readonly="readonly">' +
                          '</div>' +
                        '</td>' +

                        '<td>' +
                            '<button id="delete_row" type="button" class="btn btn-sm bg-red"><i class="fa fa-times"></i></button>' +
                        '</td>' +
                      '</tr>';

        $("#table_body_pack").append($(content));

        $('.item_pack').select2({
          dropdownParent: $('#table_body_pack')
        });

      });
    });




    $(document).ready(function() {
      $(document).on("change", "#item_pack", function() {
          var key = $(this).val();
          var parent = $(this).closest('tr');
          if(key) {
              $.ajax({
                  headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
                  url: "/api/item/select_item_byItemId/" + key,
                  type: "GET",
                  dataType: "json",
                  success:function(data) {  

                      $.each(data, function(key, value) {

                        $(parent).find(".remaining_balance").val(value.current_balance);
                        $(parent).find(".remaining_balance_unit").val(value.unit);

                        $(parent).find(".remaining_balance").priceFormat({
                            centsLimit: 3,
                            prefix: "",
                            thousandsSeparator: ",",
                            clearOnEmpty: true,
                            allowNegative: false
                        });

                      });
          
                  }
              });
          }else{
            $(parent).find(".remaining_balance").val('');
            $(parent).find(".remaining_balance_unit").val('');
          }
      });
    });



    $('.item_raw').select2({
      dropdownParent: $('#table_body_raw')
    });

    $('.item_pack').select2({
      dropdownParent: $('#table_body_pack')
    });


  </script>
    
@endsection