@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">New Purchase Order</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.purchase_order.store') }}">

        <div class="box-body">
        
          @csrf    

          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">PO Number</h3>
              </div>
              <div class="box-body">

                {!! __form::textbox(
                  '6', 'po_no', 'text', 'PO Number *', 'PO Number', old('po_no'), $errors->has('po_no'), $errors->first('po_no'), ''
                ) !!}  

                {!! __form::datepicker(
                  '6', 'date_required',  'Date Required *', old('date_required'), $errors->has('date_required'), $errors->first('date_required')
                ) !!}

              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Type</h3>
              </div>
              <div class="box-body">

                <div class="col-md-12" style="padding:25px;">

                  <label>
                    <input type="radio" class="minimal type" name="type" value="1" {{ old('type') == '1' ? 'checked' : 'checked' }}>
                    &nbsp; For Process
                  </label>

                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                  <label>
                    <input type="radio" class="minimal type" name="type" value="2" {{ old('type') == '2' ? 'checked' : '' }}>
                    &nbsp; For Delivery
                  </label>

                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                  <label>
                    <input type="radio" class="minimal type"  name="type" value="3" {{ old('type') == '3' ? 'checked' : '' }}>
                    &nbsp; For Buffer
                  </label>

                  @if($errors->has('type'))
                    <p class="text-danger" style="padding-top:10px;">{{ $errors->first('type') }}</p>
                  @endif

                </div>

              </div>
            </div>
          </div>

          <div class="col-md-12"></div>

          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Bill to</h3>
              </div>
              <div class="box-body">

                {!! __form::textbox(
                  '12', 'bill_to_name', 'text', 'Name *', 'Name', old('bill_to_name'), $errors->has('bill_to_name'), $errors->first('bill_to_name'), ''
                ) !!}  

                {!! __form::textbox(
                  '12', 'bill_to_company', 'text', 'Company *', 'Company', old('bill_to_company'), $errors->has('bill_to_company'), $errors->first('bill_to_company'), ''
                ) !!}  

                {!! __form::textbox(
                  '12', 'bill_to_address', 'text', 'Address *', 'Address', old('bill_to_address'), $errors->has('bill_to_address'), $errors->first('bill_to_address'), ''
                ) !!}

              </div>
            </div>
          </div>



          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Ship to</h3>
                  <div class="box-tools">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" class="minimal" id="fill_ship_to" value=""> &nbsp;The same as Bill to
                        </label>
                      </div>
                  </div>
              </div>
              <div class="box-body">

                {!! __form::textbox(
                  '12', 'ship_to_name', 'text', 'Name *', 'Name', old('ship_to_name'), $errors->has('ship_to_name'), $errors->first('ship_to_name'), ''
                ) !!}  

                {!! __form::textbox(
                  '12', 'ship_to_company', 'text', 'Company *', 'Company', old('ship_to_company'), $errors->has('ship_to_company'), $errors->first('ship_to_company'), ''
                ) !!}  

                {!! __form::textbox(
                  '12', 'ship_to_address', 'text', 'Address *', 'Address', old('ship_to_address'), $errors->has('ship_to_address'), $errors->first('ship_to_address'), ''
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
                  '6', 'freight_fee', 'text', 'Freight', 'Freight', old('freight_fee'), $errors->has('freight_fee'), $errors->first('freight_fee'), ''
                ) !!}

                {!! __form::textbox_numeric(
                  '6', 'vat', 'text', 'VAT (%)', 'VAT (%)', old('vat') ? old('vat') : "12.0000", $errors->has('vat'), $errors->first('vat'), ''
                ) !!}

                {!! __form::textbox(
                  '12', 'instructions', 'text', 'Shipping/Special Instructions', 'Shipping/Special Instructions', old('instructions'), $errors->has('instructions'), $errors->first('instructions'), ''
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
                    <th style="width:450px;">Item *</th>
                    <th style="width:300px;">Required Quantity</th>
                    <th style="width:200px;">Unit</th>
                    <th style="width:400px;">Current Inventory</th>
                    <th style="width: 40px"></th>
                  </tr>

                  <tbody id="table_body">

                    @if(old('row'))
                      
                      @foreach(old('row') as $key => $value)

                        <?php

                          $unit_type_list = [];
                          $class = "";

                          if ($value['unit_type_id'] == 'IU1001') {
                            $unit_type_list = ['PCS' => 'PCS', ];
                            $class = "pcs";
                          }elseif ($value['unit_type_id'] == 'IU1002') {
                            $unit_type_list = ['GRAM' => 'GRAM', 'KILOGRAM' => 'KILOGRAM'];
                            $class = "weight";
                          }elseif ($value['unit_type_id'] == 'IU1003') {
                            $unit_type_list = ['MILLILITRE' => 'MILLILITRE', 'LITRE' => 'LITRE'];
                            $class = "volume";
                          }

                        ?>

                        <tr>

                          <input type="hidden" value="{{ $value['unit_type_id'] }}" name="row[{{ $key }}][unit_type_id]" id="unit_type_id" class="unit_type_id">

                          <td>
                            <select name="row[{{ $key }}][item]" id="item" class="form-control item">
                              <option value="">Select</option>
                              @foreach($global_items_all as $data_item) 
                                  <option value="{{ $data_item->item_id }}" {!! $value['item'] == $data_item->item_id ? 'selected' : ''!!}>{{ $data_item->name }}</option>
                              @endforeach
                            </select>
                            <br><small class="text-danger">{{ $errors->first('row.'. $key .'.item') }}</small>
                          </td>

                          <td>
                            <div class="form-group">
                              <input type="text" name="row[{{ $key }}][amount]" id="amount" class="form-control {{ $class }}" placeholder="Required Quantity" value="{{ $value['amount'] }}">
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
                            <div class="form-group col-md-6 no-padding">
                              <input type="text" name="row[{{ $key }}][remaining_balance]" id="remaining_balance" class="form-control remaining_balance" placeholder="Remaining Balance" value="{{ $value['remaining_balance'] }}" readonly="readonly">
                              <small class="text-danger">{{ $errors->first('row.'. $key .'.remaining_balance') }}</small>
                            </div>
                            <div class="form-group col-md-6 no-padding">
                              <input type="text" name="row[{{ $key }}][remaining_balance_unit]" id="remaining_balance_unit" class="form-control remaining_balance_unit" placeholder="Unit" value="{{ $value['remaining_balance_unit'] }}" readonly="readonly">
                              <small class="text-danger">{{ $errors->first('row.'. $key .'.remaining_balance_unit') }}</small>
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

  {{-- PO CREATE SUCCESS --}}
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


    $('#fill_ship_to').on('ifChecked', function(event){
      $('#ship_to_name').val($('#bill_to_name').val());
      $('#ship_to_company').val($('#bill_to_company').val());
      $('#ship_to_address').val($('#bill_to_address').val());
    });
    

    $('#fill_ship_to').on('ifUnchecked', function(event){
      $('#ship_to_name').val('');
      $('#ship_to_company').val('');
      $('#ship_to_address').val('');
    });


    function textboxNumeric(id, dec){
      $(id).priceFormat({
          centsLimit: dec,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });
    }
    
    textboxNumeric("#freight_fee", 4);
    textboxNumeric("#vat", 4);
    textboxNumeric(".pcs", 0);
    textboxNumeric(".weight", 3);
    textboxNumeric(".volume", 3);
    textboxNumeric(".remaining_balance", 3);


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
                              '<option value="{{ $data->item_id }}">{{ $data->name }}</option>' +
                            '@endforeach' +
                          '</select>' +
                        '</td>' +

                        '<td>' +
                          '<div class="form-group">' +
                            '<input type="text" name="row[' + i + '][amount]" id="amount" class="form-control amount" placeholder="Required Quantity">' +
                          '</div>' +
                        '</td>' +

                        '<td>' +
                          '<div class="form-group">' +
                            '<select name="row[' + i + '][unit]"  id="unit" class="form-control unit">' +
                            '</select>' +
                          '</div>' +
                        '</td>' +

                        '<td>' +
                          '<div class="form-group col-md-6 no-padding">' +
                            '<input type="text" name="row[' + i + '][remaining_balance]" id="remaining_balance" class="form-control remaining_balance" placeholder="Remaining Balance" readonly="readonly">' +
                          '</div>' +
                          '<div class="form-group col-md-6 no-padding" >' +
                            '<input type="text" name="row[' + i + '][remaining_balance_unit]" id="remaining_balance_unit" class="form-control remaining_balance_unit" placeholder="Unit" readonly="readonly">' +
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



    {{-- AJAX Item Unit --}}
    $(document).ready(function() {
      $(document).on("change", "#item", function() {
          var key = $(this).val();
          var parent = $(this).closest('tr');

          if(key) {
            $.ajax({
              headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
              url: "/api/item/select_item_byItemId/" + key,
              type: "GET",
              dataType: "json",
              success:function(data) {  

                function textboxNumeric(id, dec){
                  $(id).priceFormat({
                      centsLimit: dec,
                      prefix: "",
                      thousandsSeparator: ",",
                      clearOnEmpty: true,
                      allowNegative: false
                  });
                }

                $(parent).find(".unit").empty();
                $(parent).find(".unit_type_id").empty();

                $.each(data, function(key, value) {

                  $(parent).find(".remaining_balance").val(value.current_balance);
                  $(parent).find(".remaining_balance_unit").val(value.unit);
                  $(parent).find(".unit_type_id").val(value.unit_type_id);

                  textboxNumeric($(parent).find(".remaining_balance"), 3);

                  if (value.unit_type_id == "IU1001") {

                    $(parent).find(".unit").append("<option value='PCS'>PCS</option>");

                    textboxNumeric($(parent).find(".amount"), 0); 

                  }else if(value.unit_type_id == "IU1002"){

                    $(parent).find(".unit").append("<option value='GRAM'>GRAMS</option>");
                    $(parent).find(".unit").append("<option value='KILOGRAM'>KILOGRAMS</option>");

                    textboxNumeric($(parent).find(".amount"), 3); 

                  }else if(value.unit_type_id == "IU1003"){

                    $(parent).find(".unit").append("<option value='MILLILITRE'>MILLILITERS</option>");
                    $(parent).find(".unit").append("<option value='LITRE'>LITERS</option>");

                    textboxNumeric($(parent).find(".amount"), 3); 

                  }
                });
      
              }
            });
          }else{
            $(parent).find(".unit").empty();
            $(parent).find(".unit_type_id").empty();
            $(parent).find(".remaining_balance").val('');
            $(parent).find(".remaining_balance_unit").val('');
          }
      });
    });


    $('.item').select2({
      width:400,
      dropdownParent: $('#table_body')
    });


  </script>
    
@endsection