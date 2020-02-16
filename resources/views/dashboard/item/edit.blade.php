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
                '12', 'product_code', 'text', 'Product Code *', 'Product Code', old('product_code') ? old('product_code') : $item->product_code, $errors->has('product_code'), $errors->first('product_code'), ''
              ) !!}

              {!! __form::select_dynamic(
                '12', 'item_category_id', 'Category *', old('item_category_id') ? old('item_category_id') : $item->item_category_id, $global_item_categories_all, 'item_category_id', 'name', $errors->has('item_category_id'), $errors->first('item_category_id'), '', ''
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
                '12', 'min_req_qty', 'text', 'Minimum Required Quantity *', 'Minimum Required Quantity', old('min_req_qty') ? old('min_req_qty') : $item->min_req_qty, $errors->has('min_req_qty'), $errors->first('min_req_qty'), ''
              ) !!}

              {!! __form::textbox_numeric(
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


    $(document).ready(function($){

      // Price Format
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


  </script>
    
@endsection

