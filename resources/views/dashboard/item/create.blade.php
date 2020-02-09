@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">Add Item</h2>
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

              <div class="col-md-12"></div>
              
              <div class="col-md-12 no-padding" id="weight_div">

                {!! __form::textbox_numeric(
                  '12', 'weight', 'text', 'Weight', 'Weight', old('weight'), $errors->has('weight'), $errors->first('weight'), ''
                ) !!}

                {!! __form::select_static(
                  '12', 'weight_unit', 'Weight Unit', old('weight_unit'), ['KILOGRAM' => 'KG', 'GRAM' => 'G', 'METRIC TON' => 'MT'], $errors->has('weight_unit'), $errors->first('weight_unit'), '', ''
                ) !!}

              </div>
              
              <div class="col-md-12 no-padding" id="volume_div">

                {!! __form::textbox_numeric(
                  '12', 'volume', 'text', 'Volume', 'Volume', old('volume'), $errors->has('volume'), $errors->first('volume'), ''
                ) !!}

                {!! __form::select_static(
                  '12', 'volume_unit', 'Volume Unit', old('volume_unit'), ['LITERS' => 'L'], $errors->has('volume_unit'), $errors->first('volume_unit'), '', ''
                ) !!}

              </div>
              
              <div class="col-md-12 no-padding" id="qty_div">

                {!! __form::textbox_numeric(
                  '12', 'quantity', 'text', 'Quantity', 'Quantity', old('quantity'), $errors->has('quantity'), $errors->first('quantity'), ''
                ) !!} 

              </div>

              {!! __form::textbox_numeric(
                '12', 'min_req_qty', 'text', 'Minimum Required Quantity *', 'Minimum Required Quantity', old('min_req_qty'), $errors->has('min_req_qty'), $errors->first('min_req_qty'), ''
              ) !!}

              {!! __form::textbox_numeric(
                '12', 'price', 'text', 'Price *', 'Price', old('price'), $errors->has('price'), $errors->first('price'), ''
              ) !!}

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

      // Price Format
      $("#weight").priceFormat({
          centsLimit: 3,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });


      $("#volume").priceFormat({
          centsLimit: 3,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });


      $("#quantity").priceFormat({
          centsLimit: 0,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });

      $("#min_req_qty").priceFormat({
          centsLimit: 3,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });

      $("#price").priceFormat({
          centsLimit: 2,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });

    });


    @if(old('unit_type_id') == 'IU1001')
      $('#qty_div').show();
      $('#weight_div').hide();
      $('#volume_div').hide();
    @elseif(old('unit_type_id') == 'IU1002')
      $('#qty_div').hide();
      $('#weight_div').show();
      $('#volume_div').hide();
    @elseif(old('unit_type_id') == 'IU1003')
      $('#qty_div').hide();
      $('#weight_div').hide();
      $('#volume_div').show();
    @else
      $( document ).ready(function() {
      $('#qty_div').hide();
      $('#weight_div').hide();
      $('#volume_div').hide();
      });
    @endif


    $(document).on("change", "#unit_type_id", function () {
      $('#quantity').val('');
      $('#weight').val('');
      $('#weight_unit').val('');
      $('#volume').val('');
      $('#volume_unit').val('');
      var val = $(this).val();
        if(val == "IU1001"){ 
          $('#qty_div').show();
          $('#weight_div').hide();
          $('#volume_div').hide();
        }else if(val == "IU1002"){
          $('#qty_div').hide();
          $('#weight_div').show();
          $('#volume_div').hide();
        }else if(val == "IU1003"){
          $('#qty_div').hide();
          $('#weight_div').hide();
          $('#volume_div').show();
        }else{
          $('#qty_div').hide();
          $('#weight_div').hide();
          $('#volume_div').hide();
        }
    });


    @if(Session::has('ITEM_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('ITEM_CREATE_SUCCESS')) !!}
    @endif


  </script>
    
@endsection