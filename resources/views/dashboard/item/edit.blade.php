@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title" style="padding-top: 5px;">Edit Item</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
            &nbsp;
            {!! __html::back_button(['dashboard.item.index']) !!}
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.item.update', $item->slug) }}">

        <div class="box-body">


          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Info</h3>
              </div>
              <div class="box-body">

              <input name="_method" value="PUT" type="hidden">
                  
              @csrf    

              {!! __form::textbox(
                '6', 'product_code', 'text', 'Product Code *', 'Product Code', old('product_code') ? old('product_code') : $item->product_code, $errors->has('product_code'), $errors->first('product_code'), ''
              ) !!}

              {!! __form::select_dynamic(
                '6', 'supplier_id', 'Supplier *', old('supplier_id') ? old('supplier_id') : $item->supplier_id, $global_suppliers_all, 'supplier_id', 'name', $errors->has('supplier_id'), $errors->first('supplier_id'), 'select2', ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::select_dynamic(
                '6', 'item_category_id', 'Category *', old('item_category_id') ? old('item_category_id') : $item->item_category_id, $global_item_categories_all, 'item_category_id', 'name', $errors->has('item_category_id'), $errors->first('item_category_id'), 'select2', ''
              ) !!}

              {!! __form::select_dynamic(
                '6', 'item_type_id', 'Type *', old('item_type_id') ? old('item_type_id') : $item->item_type_id, $global_item_types_all, 'item_type_id', 'name', $errors->has('item_type_id'), $errors->first('item_type_id'), 'select2', ''
              ) !!}

              {!! __form::textbox(
                '12', 'name', 'text', 'Name *', 'Name', old('name') ? old('name') : $item->name, $errors->has('name'), $errors->first('name'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox(
                '12', 'description', 'text', 'Description', 'Description', old('description') ? old('description') : $item->description, $errors->has('description'), $errors->first('description'), ''
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
                
                {!! __form::textbox_numeric(
                  '12', 'batch_size', 'text', 'Standard Batch Size', 'Standard Batch Size', old('batch_size') ? old('batch_size') : $item->batch_size, $errors->has('batch_size'), $errors->first('batch_size'), ''
                ) !!}

                <div class="col-md-12"></div>

                {!! __form::textbox_numeric(
                  '6', 'min_req_qty', 'text', 'Minimum Required Quantity *', 'Minimum Required Quantity', old('min_req_qty') ? old('min_req_qty') : $item->min_req_qty, $errors->has('min_req_qty'), $errors->first('min_req_qty'), ''
                ) !!}

                {!! __form::textbox_numeric(
                  '6', 'price', 'text', 'Price *', 'Price', old('price') ? old('price') : $item->price, $errors->has('price') , $errors->first('price'), ''
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
                    <th style="width: 40px"></th>
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

                    @else

                      
                      @foreach($item->itemRawMat as $key_raw => $value_raw)

                        <tr>

                          <td>
                            <select name="row_raw[{{ $key_raw }}][item]" id="item_raw" class="form-control item_raw">
                              <option value="">Select</option>
                              @foreach($global_items_all as $data) 
                                  <option value="{{ $data->item_id }}" {!! $value_raw->item_raw_mat_item_id == $data->item_id ? 'selected' : ''!!}>{{ $data->name }}</option>
                              @endforeach
                            </select>
                            <br><small class="text-danger">{{ $errors->first('row_raw.'. $key_raw .'.item') }}</small>
                          </td>

                          <td>
                            <div class="form-group col-md-6 no-padding">
                              <input type="text" name="row_raw[{{ $key_raw }}][remaining_balance]" id="remaining_balance" class="form-control remaining_balance" placeholder="Remaining Balance" value="{{ optional($value_raw->itemOrig)->current_balance }}" readonly="readonly">
                              <small class="text-danger">{{ $errors->first('row_raw.'. $key_raw .'.remaining_balance') }}</small>
                            </div>
                            <div class="form-group col-md-6 no-padding">
                              <input type="text" name="row_raw[{{ $key_raw }}][remaining_balance_unit]" id="remaining_balance_unit" class="form-control remaining_balance_unit" placeholder="Unit" value="{{ optional($value_raw->itemOrig)->unit }}" readonly="readonly">
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


                    @else

                      
                      @foreach($item->itemPackMat as $key_pack => $value_pack)

                        <tr>

                          <td>
                            <select name="row_pack[{{ $key_pack }}][item]" id="item_raw" class="form-control item_raw">
                              <option value="">Select</option>
                              @foreach($global_items_all as $data) 
                                  <option value="{{ $data->item_id }}" {!! $value_pack->item_pack_mat_item_id == $data->item_id ? 'selected' : ''!!}>{{ $data->name }}</option>
                              @endforeach
                            </select>
                            <br><small class="text-danger">{{ $errors->first('row_pack.'. $key_pack .'.item') }}</small>
                          </td>

                          <td>
                            <div class="form-group col-md-6 no-padding">
                              <input type="text" name="row_pack[{{ $key_pack }}][remaining_balance]" id="remaining_balance" class="form-control remaining_balance" placeholder="Remaining Balance" value="{{ optional($value_pack->itemOrig)->current_balance }}" readonly="readonly">
                              <small class="text-danger">{{ $errors->first('row_pack.'. $key_pack .'.remaining_balance') }}</small>
                            </div>
                            <div class="form-group col-md-6 no-padding">
                              <input type="text" name="row_pack[{{ $key_pack }}][remaining_balance_unit]" id="remaining_balance_unit" class="form-control remaining_balance_unit" placeholder="Unit" value="{{ optional($value_pack->itemOrig)->unit }}" readonly="readonly">
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


    $(document).ready(function($){

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
      textboxNumeric("#min_req_qty", 3);
      textboxNumeric(".remaining_balance", 3);

      @if($item->unit_type_id == 'IU1001')

        $("#batch_size_unit").empty();
        $("#batch_size_unit").append("<option value='PCS'{{ old('batch_size_unit') == 'PCS' ? 'selected' : '' }}>PCS</option>");

      @elseif($item->unit_type_id == 'IU1002')

        $("#batch_size_unit").empty();
        $("#batch_size_unit").append("<option value>Select</option>");
        $("#batch_size_unit").append("<option value='GRAM' {{ $item->batch_size_unit == 'GRAM' ? 'selected' : '' }}>GRAMS</option>");
        $("#batch_size_unit").append("<option value='KILOGRAM' {{ $item->batch_size_unit == 'KILOGRAM' ? 'selected' : '' }}>KILOGRAMS</option>");

      @elseif($item->unit_type_id == 'IU1003')

        $("#batch_size_unit").empty();
        $("#batch_size_unit").append("<option value>Select</option>");
        $("#batch_size_unit").append("<option value='MILLILITRE' {{ $item->batch_size_unit == 'MILLILITRE' ? 'selected' : '' }}>MILLILITERS</option>");
        $("#batch_size_unit").append("<option value='LITRE' {{ $item->batch_size_unit == 'LITRE' ? 'selected' : '' }}>LITERS</option>");

      @else

        $("#batch_size_unit").empty();

      @endif

    });


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

