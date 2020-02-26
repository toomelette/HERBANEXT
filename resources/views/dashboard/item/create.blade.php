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

    $("#price").priceFormat({
        centsLimit: 2,
        prefix: "",
        thousandsSeparator: ",",
        clearOnEmpty: true,
        allowNegative: false
    });

    @if(old('unit_type_id') == 'IU1001')
      $("#unit").empty();
      $("#unit").append("<option value='PCS'{{ old('unit') == 'PCS' ? 'selected' : '' }}>PCS</option>");
      $("#beginning_balance").priceFormat({
          centsLimit: 0,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });
      $("#min_req_qty").priceFormat({
          centsLimit: 0,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });
    @elseif(old('unit_type_id') == 'IU1002')
      $("#unit").empty();
      $("#unit").append("<option value>Select</option>");
      $("#unit").append("<option value='GRAM' {{ old('unit') == 'GRAM' ? 'selected' : '' }}>GRAMS</option>");
      $("#unit").append("<option value='KILOGRAM' {{ old('unit') == 'KILOGRAM' ? 'selected' : '' }}>KILOGRAMS</option>");
      $("#beginning_balance").priceFormat({
          centsLimit: 3,
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
    @elseif(old('unit_type_id') == 'IU1003')
      $("#unit").empty();
      $("#unit").append("<option value>Select</option>");
      $("#unit").append("<option value='MILLILITRE' {{ old('unit') == 'MILLILITRE' ? 'selected' : '' }}>MILLILITERS</option>");
      $("#unit").append("<option value='LITRE' {{ old('unit') == 'LITRE' ? 'selected' : '' }}>LITERS</option>");
      $("#beginning_balance").priceFormat({
          centsLimit: 3,
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
    @else
      $("#unit").empty();
      $("#beginning_balance").priceFormat({
          centsLimit: 0,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });
      $("#min_req_qty").priceFormat({
          centsLimit: 0,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });
    @endif




    $(document).on("change", "#unit_type_id", function () {
      
      var val = $(this).val();
        
      if(val == "IU1001"){ 
        $("#unit").empty();
        $("#unit").append("<option value='PCS'>PCS</option>");
        $("#beginning_balance").priceFormat({
            centsLimit: 0,
            prefix: "",
            thousandsSeparator: ",",
            clearOnEmpty: true,
            allowNegative: false
        });
        $("#min_req_qty").priceFormat({
            centsLimit: 0,
            prefix: "",
            thousandsSeparator: ",",
            clearOnEmpty: true,
            allowNegative: false
        });
      }else if(val == "IU1002"){
        $("#unit").empty();
        $("#unit").append("<option value>Select</option>");
        $("#unit").append("<option value='GRAM'>GRAMS</option>");
        $("#unit").append("<option value='KILOGRAM'>KILOGRAMS</option>");
        $("#beginning_balance").priceFormat({
            centsLimit: 3,
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
      }else if(val == "IU1003"){
        $("#unit").empty();
        $("#unit").append("<option value>Select</option>");
        $("#unit").append("<option value='MILLILITRE'>MILLILITERS</option>");
        $("#unit").append("<option value='LITRE'>LITERS</option>");
        $("#beginning_balance").priceFormat({
            centsLimit: 3,
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
      }else{
        $("#unit").empty();
        $("#beginning_balance").priceFormat({
            centsLimit: 0,
            prefix: "",
            thousandsSeparator: ",",
            clearOnEmpty: true,
            allowNegative: false
        });
        $("#min_req_qty").priceFormat({
            centsLimit: 0,
            prefix: "",
            thousandsSeparator: ",",
            clearOnEmpty: true,
            allowNegative: false
        });
      }

    });


    @if(Session::has('ITEM_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('ITEM_CREATE_SUCCESS')) !!}
    @endif


  </script>
    
@endsection