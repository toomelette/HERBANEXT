@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">Edit Purchase Order</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
            &nbsp;
            {!! __html::back_button(['dashboard.purchase_order.index']) !!}
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.purchase_order.update', $purchase_order->slug) }}">

        <div class="box-body">
          
          @csrf    

          <input name="_method" value="PUT" type="hidden">

          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Bill to</h3>
              </div>
              <div class="box-body">

                {!! __form::textbox(
                  '12', 'bill_to_name', 'text', 'Name *', 'Name', old('bill_to_name') ? old('bill_to_name') : $purchase_order->bill_to_name, $errors->has('bill_to_name'), $errors->first('bill_to_name'), ''
                ) !!}  

                {!! __form::textbox(
                  '12', 'bill_to_company', 'text', 'Company *', 'Company', old('bill_to_company') ? old('bill_to_company') : $purchase_order->bill_to_company, $errors->has('bill_to_company'), $errors->first('bill_to_company'), ''
                ) !!}  

                {!! __form::textbox(
                  '12', 'bill_to_address', 'text', 'Address *', 'Address', old('bill_to_address') ? old('bill_to_address') : $purchase_order->bill_to_address, $errors->has('bill_to_address'), $errors->first('bill_to_address'), ''
                ) !!}

              </div>
            </div>
          </div>



          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Ship to</h3>
              </div>
              <div class="box-body">

                {!! __form::textbox(
                  '12', 'ship_to_name', 'text', 'Name *', 'Name', old('ship_to_name') ? old('ship_to_name') : $purchase_order->ship_to_name, $errors->has('ship_to_name'), $errors->first('ship_to_name'), ''
                ) !!}  

                {!! __form::textbox(
                  '12', 'ship_to_company', 'text', 'Company *', 'Company', old('ship_to_company') ? old('ship_to_company') : $purchase_order->ship_to_company, $errors->has('ship_to_company'), $errors->first('ship_to_company'), ''
                ) !!}  

                {!! __form::textbox(
                  '12', 'ship_to_address', 'text', 'Address *', 'Address', old('ship_to_address') ? old('ship_to_address') : $purchase_order->ship_to_address, $errors->has('ship_to_address'), $errors->first('ship_to_address'), ''
                ) !!}

              </div>
            </div>
          </div>





          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Others</h3>
              </div>
              <div class="box-body">

                {!! __form::textbox_numeric(
                  '6', 'freight_fee', 'text', 'Freight', 'Freight', old('freight_fee') ? old('freight_fee') : $purchase_order->freight_fee, $errors->has('freight_fee'), $errors->first('freight_fee'), ''
                ) !!}

                {!! __form::textbox_numeric(
                  '6', 'vat', 'text', 'VAT (%)', 'VAT (%)', old('vat') ? old('vat') : $purchase_order->vat, $errors->has('vat'), $errors->first('vat'), ''
                ) !!}

                {!! __form::textbox(
                  '12', 'instructions', 'text', 'Shipping/Special Instructions', 'Shipping/Special Instructions', old('instructions') ? old('instructions') : $purchase_order->instructions, $errors->has('instructions'), $errors->first('instructions'), ''
                ) !!}

              </div>
            </div>
          </div>




          <div class="col-md-12" style="padding-top:20px;">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Items</h3>
                <button id="add_row" type="button" class="btn btn-sm bg-green pull-right">Add Item &nbsp;<i class="fa fw fa-plus"></i></button>
              </div>
              
              <div class="box-body no-padding">
                
                <table class="table table-bordered">

                  <tr>
                    <th style="width:400px;">Item *</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th style="width: 40px"></th>
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

                          <input type="hidden" value="{{ $value['unit_type_id'] }}" name="row[{{ $key }}][unit_type_id]" id="unit_type_id" class="unit_type_id">

                          <td>
                            <select name="row[{{ $key }}][item]" id="item" class="form-control item">
                              <option value="">Select</option>
                              @foreach($global_items_all as $data_item) 
                                  <option value="{{ $data_item->product_code }}" {!! $value['item'] == $data_item->product_code ? 'selected' : ''!!}>{{ $data_item->name }}</option>
                              @endforeach
                            </select>
                            <br><small class="text-danger">{{ $errors->first('row.'. $key .'.item') }}</small>
                          </td>

                          <td>
                            <div class="form-group">
                              <input type="text" name="row[{{ $key }}][amount]" id="amount" class="form-control amount" placeholder="Quantity" value="{{ $value['amount'] }}">
                              <small class="text-danger">{{ $errors->first('row.'. $key .'.amount') }}</small>
                            </div>
                          </td>

                          <td>
                            
                          <div class="form-group">
                            <select name="row[{{ $key }}][unit]"  id="unit" class="form-control unit">
                              @foreach($unit_type_list as $key_unit => $data_unit)
                                <option value="{{ $key_unit }}" {!! $value['unit'] == $key_unit ? 'selected' : ''!!}>{{ $data_unit }}</option>
                              @endforeach
                            </select>
                          </div>

                          </td>

                          <td>
                            <button id="delete_row" type="button" class="btn btn-sm bg-red"><i class="fa fa-times"></i></button>
                          </td>

                        </tr>

                      @endforeach


                    @else
                      
                      @foreach($purchase_order->purchaseOrderItem as $key => $data)

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

                          <input type="hidden" value="{{ $data->unit_type_id }}" name="row[{{ $key }}][unit_type_id]" id="unit_type_id" class="unit_type_id">

                          <td>
                            <select name="row[{{ $key }}][item]" id="item" class="form-control item">
                              <option value="">Select</option>
                              @foreach($global_items_all as $data_item) 
                                  <option value="{{ $data_item->product_code }}" {!! $data->product_code == $data_item->product_code ? 'selected' : ''!!}>{{ $data_item->name }}</option>
                              @endforeach
                            </select>
                            <br><small class="text-danger">{{ $errors->first('row.'. $key .'.item') }}</small>
                          </td>

                          <td>
                            <div class="form-group">
                              <input type="text" name="row[{{ $key }}][amount]" id="amount" class="form-control amount" placeholder="Quantity" value="{{ $data->amount }}">
                              <small class="text-danger">{{ $errors->first('row.'. $key .'.amount') }}</small>
                            </div>
                          </td>

                          <td>
                            
                          <div class="form-group">
                            <select name="row[{{ $key }}][unit]"  id="unit" class="form-control unit">
                              @foreach($unit_type_list as $key_unit => $data_unit)
                                <option value="{{ $key_unit }}" {!! $data->unit == $key_unit ? 'selected' : ''!!}>{{ $data_unit }}</option>
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





@section('modals')

  {{-- DV CREATE SUCCESS --}}
  @if(Session::has('PURCHASE_ORDER_CREATE_SUCCESS'))

    {!! __html::modal_print(
      'po_create', '<i class="fa fa-fw fa-check"></i> Saved!', Session::get('PURCHASE_ORDER_CREATE_SUCCESS'), route('dashboard.purchase_order.show', Session::get('PURCHASE_ORDER_CREATE_SUCCESS_SLUG'))
    ) !!}

  @endif

@endsection 




@section('scripts')

  <script type="text/javascript">
  
    @if(Session::has('PURCHASE_ORDER_CREATE_SUCCESS'))
      $('#po_create').modal('show');
    @endif


    $("#freight_fee").priceFormat({
        centsLimit: 2,
        prefix: "",
        thousandsSeparator: ",",
        clearOnEmpty: true,
        allowNegative: false
    });


    $("#vat").priceFormat({
        centsLimit: 2,
        prefix: "",
        thousandsSeparator: ",",
        clearOnEmpty: true,
        allowNegative: false
    });


    {{-- ADD ROW --}}
    $(document).ready(function() {
      $("#add_row").on("click", function() {
          var i = $("#table_body").children().length;
          $('.item').select2('destroy');
          var content ='<tr>' +

                        '<input type="hidden" name="row[' + i + '][unit_type_id]" id="unit_type_id" class="unit_type_id">' +

                        '<td>' +
                          '<select name="row[' + i + '][item]" id="item" class="form-control item">' +
                            '<option value="">Select</option>' +
                            '@foreach($global_items_all as $data)' +
                              '<option value="{{ $data->product_code }}">{{ $data->name }}</option>' +
                            '@endforeach' +
                          '</select>' +
                        '</td>' +

                        '<td>' +
                          '<div class="form-group">' +
                            '<input type="text" name="row[' + i + '][amount]" id="amount" class="form-control amount" placeholder="Quantity">' +
                          '</div>' +
                        '</td>' +

                        '<td>' +
                          '<div class="form-group">' +
                            '<select name="row[' + i + '][unit]"  id="unit" class="form-control unit">' +
                            '</select>' +
                          '</div>' +
                        '</td>' +

                        '<td>' +
                            '<button id="delete_row" type="button" class="btn btn-sm bg-red"><i class="fa fa-times"></i></button>' +
                        '</td>' +
                      '</tr>';

        $("#table_body").append($(content));

        $('.item').select2({
          width:400,
          dropdownParent: $('#table_body')
        });

      });
    });





    {{-- AJAX PO Unit --}}
    $(document).ready(function() {
      $(document).on("change", "#item", function() {
          var key = $(this).val();
          var parent = $(this).closest('tr');
          if(key) {
              $.ajax({
                  headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
                  url: "/api/item/select_item_byProductCode/" + key,
                  type: "GET",
                  dataType: "json",
                  success:function(data) {  

                      $(parent).find("#unit").empty();
                      $(parent).find("#unit_type_id").empty();
                      $.each(data, function(key, value) {

                        $(parent).find(".unit_type_id").val(value.unit_type_id);

                        if (value.unit_type_id == "IU1001") {

                          $(parent).find(".unit").append("<option value='PCS'>PCS</option>");
                          $(parent).find(".amount").priceFormat({
                              centsLimit: 0,
                              prefix: "",
                              thousandsSeparator: ",",
                              clearOnEmpty: true,
                              allowNegative: false
                          });

                        }else if(value.unit_type_id == "IU1002"){

                          $(parent).find(".unit").append("<option value='GRAM'>GRAMS</option>");
                          $(parent).find(".unit").append("<option value='KILOGRAM'>KILOGRAMS</option>");
                          $(parent).find(".amount").priceFormat({
                              centsLimit: 3,
                              prefix: "",
                              thousandsSeparator: ",",
                              clearOnEmpty: true,
                              allowNegative: false
                          });

                        }else if(value.unit_type_id == "IU1003"){

                          $(parent).find(".unit").append("<option value='MILLILITRE'>MILLILITERS</option>");
                          $(parent).find(".unit").append("<option value='LITRE'>LITERS</option>");
                          $(parent).find(".amount").priceFormat({
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
            $(parent).find("#unit").empty();
            $(parent).find("#unit_type_id").empty();
          }
      });
    });


    $('.item').select2({
      width:400,
      dropdownParent: $('#table_body')
    });


  </script>
    
@endsection