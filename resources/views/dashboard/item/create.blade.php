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
                '12', 'product_code', 'text', 'Product Code *', 'Product Code', old('product_code'), $errors->has('product_code'), $errors->first('product_code'), ''
              ) !!}

              {!! __form::select_dynamic(
                '12', 'item_category_id', 'Category *', old('item_category_id'), $global_item_categories_all, 'item_category_id', 'name', $errors->has('item_category_id'), $errors->first('item_category_id'), '', ''
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
                '6', 'beginning_balance', 'text', 'Beggining Balance *', 'Beggining Balance *', old('beginning_balance'), $errors->has('beginning_balance'), $errors->first('beginning_balance'), ''
              ) !!}

              {!! __form::select_static(
                '6', 'unit', 'Standard Unit *', old('unit'), [], $errors->has('unit'), $errors->first('unit'), '', ''
              ) !!}

              {!! __form::textbox_numeric(
                '12', 'min_req_qty', 'text', 'Minimum Required Quantity *', 'Minimum Required Quantity', old('min_req_qty'), $errors->has('min_req_qty'), $errors->first('min_req_qty'), ''
              ) !!}

              {!! __form::textbox_numeric(
                '12', 'price', 'text', 'Price', 'Price', old('price'), $errors->has('price'), $errors->first('price'), ''
              ) !!}

              </div>
            </div>
          </div>




          {{-- Raw Materials --}}
          <div class="col-md-12" style="padding-top:20px;">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Raw Materials</h3>
                <button id="add_row_raw" type="button" class="btn btn-sm bg-green pull-right">Add New &nbsp;<i class="fa fw fa-plus"></i></button>
              </div>
              
              <div class="box-body no-padding">
                
                <table class="table table-bordered">

                  <tr>
                    <th style="width:400px;">Item *</th>
                    <th>Required Quantity</th>
                    <th>Unit</th>
                    <th style="width: 40px"></th>
                  </tr>

                  <tbody id="table_body_raw">

                    @if(old('row_raw'))
                      
                      @foreach(old('row_raw') as $key_raw => $value_raw)

                        <?php

                          $unit_type_list = [];

                          if ($value_raw['unit_type_id'] == 'IU1001') {
                            $unit_type_list = ['PCS' => 'PCS', ];
                          }elseif ($value_raw['unit_type_id'] == 'IU1002') {
                            $unit_type_list = ['GRAM' => 'GRAM', 'KILOGRAM' => 'KILOGRAM'];
                          }elseif ($value_raw['unit_type_id'] == 'IU1003') {
                            $unit_type_list = ['MILLILITRE' => 'MILLILITRE', 'LITRE' => 'LITRE'];
                          }

                        ?>

                        <tr>

                          <input type="hidden" name="row_raw[{{ $key_raw }}][unit_type_id]" id="unit_type_id_raw" class="unit_type_id_raw">

                          <td>
                            <select name="row_raw[{{ $key_raw }}][item]" id="item_raw" class="form-control item_raw">
                              <option value="">Select</option>
                              @foreach($global_items_all as $data) 
                                  <option value="{{ $data->product_code }}" {!! $value_raw['item'] == $data->product_code ? 'selected' : ''!!}>{{ $data->name }}</option>
                              @endforeach
                            </select>
                            <br><small class="text-danger">{{ $errors->first('row_raw.'. $key_raw .'.item') }}</small>
                          </td>

                          <td>
                            <div class="form-group">
                              <input type="text" name="row_raw[{{ $key_raw }}][required_quantity]" id="required_quantity_raw" class="form-control required_quantity_raw" placeholder="Quantity" value="{{ $value_raw['required_quantity'] }}">
                              <small class="text-danger">{{ $errors->first('row_raw.'. $key_raw .'.required_quantity') }}</small>
                            </div>
                          </td>

                          <td>
                            
                          <div class="form-group">
                            <select name="row_raw[{{ $key_raw }}][unit]"  id="unit_raw" class="form-control unit_raw">
                              @foreach($unit_type_list as $data)
                                <option value="{{ $data }}" {!! $value_raw['unit'] == $data ? 'selected' : ''!!}>{{ $data }}</option>
                              @endforeach
                            </select>
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
          <div class="col-md-12" style="padding-top:20px;">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Packaging Materials</h3>
                <button id="add_row_pack" type="button" class="btn btn-sm bg-green pull-right">Add New &nbsp;<i class="fa fw fa-plus"></i></button>
              </div>
              
              <div class="box-body no-padding">
                
                <table class="table table-bordered">

                  <tr>
                    <th style="width:400px;">Item *</th>
                    <th>Required Quantity</th>
                    <th>Unit</th>
                    <th style="width: 40px"></th>
                  </tr>

                  <tbody id="table_body_pack">

                    @if(old('row_pack'))
                      
                      @foreach(old('row_pack') as $key_pack => $value_pack)

                        <?php

                          $unit_type_list = [];

                          if ($value_pack['unit_type_id'] == 'IU1001') {
                            $unit_type_list = ['PCS' => 'PCS', ];
                          }elseif ($value_pack['unit_type_id'] == 'IU1002') {
                            $unit_type_list = ['GRAM' => 'GRAM', 'KILOGRAM' => 'KILOGRAM'];
                          }elseif ($value_pack['unit_type_id'] == 'IU1003') {
                            $unit_type_list = ['MILLILITRE' => 'MILLILITRE', 'LITRE' => 'LITRE'];
                          }

                        ?>

                        <tr>

                          <input type="hidden" name="row_pack[{{ $key_pack }}][unit_type_id]" id="unit_type_id_pack" class="unit_type_id_pack">

                          <td>
                            <select name="row_pack[{{ $key_pack }}][item]" id="item_pack" class="form-control item_pack">
                              <option value="">Select</option>
                              @foreach($global_items_all as $data) 
                                  <option value="{{ $data->product_code }}" {!! $value_pack['item'] == $data->product_code ? 'selected' : ''!!}>{{ $data->name }}</option>
                              @endforeach
                            </select>
                            <br><small class="text-danger">{{ $errors->first('row_pack.'. $key_pack .'.item') }}</small>
                          </td>

                          <td>
                            <div class="form-group">
                              <input type="text" name="row_pack[{{ $key_pack }}][required_quantity]" id="required_quantity_pack" class="form-control required_quantity_pack" placeholder="Quantity" value="{{ $value_pack['required_quantity'] }}">
                              <small class="text-danger">{{ $errors->first('row_pack.'. $key_pack .'.required_quantity') }}</small>
                            </div>
                          </td>

                          <td>
                            
                          <div class="form-group">
                            <select name="row_mat[{{ $key_pack }}][unit]"  id="unit_pack" class="form-control unit_pack">
                              @foreach($unit_type_list as $data)
                                <option value="{{ $data }}" {!! $value_pack['unit'] == $data ? 'selected' : ''!!}>{{ $data }}</option>
                              @endforeach
                            </select>
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

    textboxNumeric("#price", 2);

    @if(old('unit_type_id') == 'IU1001')
      $("#unit").empty();
      $("#unit").append("<option value_raw='PCS'{{ old('unit') == 'PCS' ? 'selected' : '' }}>PCS</option>");
      textboxNumeric("#beginning_balance", 0);
      textboxNumeric("#min_req_qty", 0);
    @elseif(old('unit_type_id') == 'IU1002')
      $("#unit").empty();
      $("#unit").append("<option value_raw>Select</option>");
      $("#unit").append("<option value_raw='GRAM' {{ old('unit') == 'GRAM' ? 'selected' : '' }}>GRAMS</option>");
      $("#unit").append("<option value_raw='KILOGRAM' {{ old('unit') == 'KILOGRAM' ? 'selected' : '' }}>KILOGRAMS</option>");
      textboxNumeric("#beginning_balance", 3);
      textboxNumeric("#min_req_qty", 3);
    @elseif(old('unit_type_id') == 'IU1003')
      $("#unit").empty();
      $("#unit").append("<option value_raw>Select</option>");
      $("#unit").append("<option value_raw='MILLILITRE' {{ old('unit') == 'MILLILITRE' ? 'selected' : '' }}>MILLILITERS</option>");
      $("#unit").append("<option value_raw='LITRE' {{ old('unit') == 'LITRE' ? 'selected' : '' }}>LITERS</option>");
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
        $("#unit").append("<option value_raw='PCS'>PCS</option>");
        textboxNumeric("#beginning_balance", 0);
        textboxNumeric("#min_req_qty", 0);
      }else if(val == "IU1002"){
        $("#unit").empty();
        $("#unit").append("<option value_raw>Select</option>");
        $("#unit").append("<option value_raw='GRAM'>GRAMS</option>");
        $("#unit").append("<option value_raw='KILOGRAM'>KILOGRAMS</option>");
        textboxNumeric("#beginning_balance", 3);
        textboxNumeric("#min_req_qty", 3);
      }else if(val == "IU1003"){
        $("#unit").empty();
        $("#unit").append("<option value_raw>Select</option>");
        $("#unit").append("<option value_raw='MILLILITRE'>MILLILITERS</option>");
        $("#unit").append("<option value_raw='LITRE'>LITERS</option>");
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

                        '<input type="hidden" name="row_raw[' + i + '][unit_type_id]" id="unit_type_id_raw" class="unit_type_id_raw">' +

                        '<td>' +
                          '<select name="row_raw[' + i + '][item]" id="item_raw" class="form-control item_raw">' +
                            '<option value="">Select</option>' +
                            '@foreach($global_raw_mat_items_all as $data)' +
                              '<option value="{{ $data->product_code }}">{{ $data->name }}</option>' +
                            '@endforeach' +
                          '</select>' +
                        '</td>' +

                        '<td>' +
                          '<div class="form-group">' +
                            '<input type="text" name="row_raw[' + i + '][required_quantity]" id="required_quantity_raw" class="form-control required_quantity_raw" placeholder="Quantity">' +
                          '</div>' +
                        '</td>' +

                        '<td>' +
                          '<div class="form-group">' +
                            '<select name="row_raw[' + i + '][unit]"  id="unit_raw" class="form-control unit_raw">' +
                            '</select>' +
                          '</div>' +
                        '</td>' +

                        '<td>' +
                            '<button id="delete_row" type="button" class="btn btn-sm bg-red"><i class="fa fa-times"></i></button>' +
                        '</td>' +
                      '</tr>';

        $("#table_body_raw").append($(content));

        $('.item_raw').select2({
          width:400,
          dropdownParent: $('#table_body_raw')
        });

      });
    });




    {{-- AJAX Raw Mats --}}
    $(document).ready(function() {
      $(document).on("change", "#item_raw", function() {
          var key = $(this).val();
          var parent = $(this).closest('tr');
          if(key) {
              $.ajax({
                  headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
                  url: "/api/item/select_item_byProductCode/" + key,
                  type: "GET",
                  dataType: "json",
                  success:function(data) {  

                      $(parent).find("#unit_raw").empty();
                      $(parent).find("#unit_type_id_raw").empty();
                      $.each(data, function(key, value) {

                        $(parent).find(".unit_type_id_raw").val(value.unit_type_id);

                        if (value.unit_type_id == "IU1001") {

                          $(parent).find(".unit_raw").append("<option value='PCS'>PCS</option>");
                          $(parent).find(".required_quantity_raw").priceFormat({
                              centsLimit: 0,
                              prefix: "",
                              thousandsSeparator: ",",
                              clearOnEmpty: true,
                              allowNegative: false
                          });

                        }else if(value.unit_type_id == "IU1002"){

                          $(parent).find(".unit_raw").append("<option value='GRAM'>GRAMS</option>");
                          $(parent).find(".unit_raw").append("<option value='KILOGRAM'>KILOGRAMS</option>");
                          $(parent).find(".required_quantity_raw").priceFormat({
                              centsLimit: 3,
                              prefix: "",
                              thousandsSeparator: ",",
                              clearOnEmpty: true,
                              allowNegative: false
                          });

                        }else if(value.unit_type_id == "IU1003"){

                          $(parent).find(".unit_raw").append("<option value='MILLILITRE'>MILLILITERS</option>");
                          $(parent).find(".unit_raw").append("<option value='LITRE'>LITERS</option>");
                          $(parent).find(".required_quantity_raw").priceFormat({
                              centsLimit: 3,
                              prefix: "",
                              thousandsSeparator: ",",
                              clearOnEmpty: true,
                              allowNegative: false
                          });

                        }
                      });
          
                  }
              });
          }else{
            $(parent).find("#unit_raw").empty();
            $(parent).find("#unit_type_id_raw").empty();
          }
      });
    });








    {{-- ADD PACK Mats --}}
    $(document).ready(function() {
      $("#add_row_pack").on("click", function() {
          var i = $("#table_body_pack").children().length;
          $('.item_pack').select2('destroy');
          var content ='<tr>' +

                        '<input type="hidden" name="row_pack[' + i + '][unit_type_id]" id="unit_type_id_pack" class="unit_type_id_pack">' +

                        '<td>' +
                          '<select name="row_pack[' + i + '][item]" id="item_pack" class="form-control item_pack">' +
                            '<option value="">Select</option>' +
                            '@foreach($global_pack_mat_items_all as $data)' +
                              '<option value="{{ $data->product_code }}">{{ $data->name }}</option>' +
                            '@endforeach' +
                          '</select>' +
                        '</td>' +

                        '<td>' +
                          '<div class="form-group">' +
                            '<input type="text" name="row_pack[' + i + '][required_quantity]" id="required_quantity_pack" class="form-control required_quantity_pack" placeholder="Quantity">' +
                          '</div>' +
                        '</td>' +

                        '<td>' +
                          '<div class="form-group">' +
                            '<select name="row_pack[' + i + '][unit]"  id="unit_pack" class="form-control unit_pack">' +
                            '</select>' +
                          '</div>' +
                        '</td>' +

                        '<td>' +
                            '<button id="delete_row" type="button" class="btn btn-sm bg-red"><i class="fa fa-times"></i></button>' +
                        '</td>' +
                      '</tr>';

        $("#table_body_pack").append($(content));

        $('.item_pack').select2({
          width:400,
          dropdownParent: $('#table_body_pack')
        });

      });
    });




    {{-- AJAX PACK Mats --}}
    $(document).ready(function() {
      $(document).on("change", "#item_pack", function() {
          var key = $(this).val();
          var parent = $(this).closest('tr');
          if(key) {
              $.ajax({
                  headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
                  url: "/api/item/select_item_byProductCode/" + key,
                  type: "GET",
                  dataType: "json",
                  success:function(data) {  

                      $(parent).find("#unit_pack").empty();
                      $(parent).find("#unit_type_id_pack").empty();
                      $.each(data, function(key, value) {

                        $(parent).find(".unit_type_id_pack").val(value.unit_type_id);

                        if (value.unit_type_id == "IU1001") {

                          $(parent).find(".unit_raw").append("<option value='PCS'>PCS</option>");
                          $(parent).find(".required_quantity_pack").priceFormat({
                              centsLimit: 0,
                              prefix: "",
                              thousandsSeparator: ",",
                              clearOnEmpty: true,
                              allowNegative: false
                          });

                        }else if(value.unit_type_id == "IU1002"){

                          $(parent).find(".unit_pack").append("<option value='GRAM'>GRAMS</option>");
                          $(parent).find(".unit_pack").append("<option value='KILOGRAM'>KILOGRAMS</option>");
                          $(parent).find(".required_quantity_pack").priceFormat({
                              centsLimit: 3,
                              prefix: "",
                              thousandsSeparator: ",",
                              clearOnEmpty: true,
                              allowNegative: false
                          });

                        }else if(value.unit_type_id == "IU1003"){

                          $(parent).find(".unit_pack").append("<option value='MILLILITRE'>MILLILITERS</option>");
                          $(parent).find(".unit_pack").append("<option value='LITRE'>LITERS</option>");
                          $(parent).find(".required_quantity_pack").priceFormat({
                              centsLimit: 3,
                              prefix: "",
                              thousandsSeparator: ",",
                              clearOnEmpty: true,
                              allowNegative: false
                          });

                        }
                      });
          
                  }
              });
          }else{
            $(parent).find("#unit_pack").empty();
            $(parent).find("#unit_type_id_pack").empty();
          }
      });
    });






    $('.item_raw').select2({
      width:400,
      dropdownParent: $('#table_body_raw')
    });


    $('.item_pack').select2({
      width:400,
      dropdownParent: $('#table_body_pack')
    });


  </script>
    
@endsection