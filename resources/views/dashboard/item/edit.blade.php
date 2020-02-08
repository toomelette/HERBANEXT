@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">Edit Item</h2>
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
                '12', 'product_code', 'text', 'Product Code *', 'Product Code', old('product_code') ? old('product_code') : $item->product_code, $errors->has('product_code'), $errors->first('product_code'), ''
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

              {!! __form::select_static(
                '12', 'item_unit_id', 'Unit Type *', old('item_unit_id') ? old('item_unit_id') : $item->item_unit_id, ['BY WEIGHT' => 'IU1001', 'BY QUANTITY' => 'IU1002'], $errors->has('item_unit_id'), $errors->first('item_unit_id'), '', ''
              ) !!}
              
              <div class="col-md-12 no-padding" id="weight_div">

                {!! __form::textbox(
                  '12', 'weight', 'text', 'Weight', 'Weight', old('weight') ? old('weight') : $item->weight, $errors->has('weight'), $errors->first('weight'), ''
                ) !!} 

                {!! __form::select_static(
                  '12', 'weight_unit', 'Weight Unit *', old('weight_unit') ? old('weight_unit') : $item->weight_unit, ['KILOGRAM' => 'KG', 'GRAM' => 'G'], $errors->has('weight_unit'), $errors->first('weight_unit'), '', ''
                ) !!}

              </div>
              
              <div class="col-md-12 no-padding" id="qty_div">

                {!! __form::textbox(
                  '12', 'quantity', 'text', 'Quantity', 'Quantity', old('quantity') ? old('quantity') : $item->quantity, $errors->has('quantity'), $errors->first('quantity'), ''
                ) !!} 

              </div>

              {!! __form::textbox(
                '12', 'min_req_qty', 'text', 'Minimum Required Quantity *', 'Minimum Required Quantity', old('min_req_qty') ? old('min_req_qty') : $item->min_req_qty, $errors->has('min_req_qty'), $errors->first('min_req_qty'), ''
              ) !!}

              {!! __form::textbox(
                '12', 'price', 'text', 'Price *', 'Price', old('price') ? old('price') : $item->price, $errors->has('price') , $errors->first('price'), ''
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


    @if($item->item_unit_id == 'IU1001')
      $('#weight_div').show();
      $('#qty_div').hide();
    @elseif($item->item_unit_id == 'IU1002')
      $('#weight_div').hide();
      $('#qty_div').show();
    @else
      $( document ).ready(function() {
        $('#weight_div').hide();
        $('#qty_div').hide();
      });
    @endif


    @if(old('item_unit_id') == 'IU1001')
      $('#weight_div').show();
      $('#qty_div').hide();
    @elseif(old('item_unit_id') == 'IU1002')
      $('#weight_div').hide();
      $('#qty_div').show();
    @endif


    $(document).on("change", "#item_unit_id", function () {
      $('#weight').val('');
      $('#weight_unit').val('');
      $('#quantity').val('');
      var val = $(this).val();
        if(val == "IU1001"){ 
          $('#weight_div').show();
          $('#qty_div').hide();
        }else if(val == "IU1002"){
          $('#weight_div').hide();
          $('#qty_div').show();
        }else{
          $('#weight_div').hide();
          $('#qty_div').hide();
        }
    });


  </script>
    
@endsection