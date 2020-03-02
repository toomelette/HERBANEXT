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
                    <th style="width: 40px"></th>
                  </tr>

                  <tbody id="table_body_raw">

                    @if(old('row_raw'))
                      
                      @foreach(old('row_raw') as $key_raw => $value_raw)

                        <tr>

                          <td>
                            <select name="row_raw[{{ $key_raw }}][item]" id="item_raw" class="form-control item_raw">
                              <option value="">Select</option>
                              @foreach($global_raw_mat_items_all as $data) 
                                  <option value="{{ $data->product_code }}" {!! $value_raw['item'] == $data->product_code ? 'selected' : ''!!}>{{ $data->name }}</option>
                              @endforeach
                            </select>
                            <br><small class="text-danger">{{ $errors->first('row_raw.'. $key_raw .'.item') }}</small>
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
                              @foreach($global_raw_mat_items_all as $data) 
                                  <option value="{{ $data->product_code }}" {!! $value_raw->item_raw_mat_product_code == $data->product_code ? 'selected' : ''!!}>{{ $data->name }}</option>
                              @endforeach
                            </select>
                            <br><small class="text-danger">{{ $errors->first('row_raw.'. $key_raw .'.item') }}</small>
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
                    <th style="width: 40px"></th>
                  </tr>

                  <tbody id="table_body_pack">

                    @if(old('row_pack'))
                      
                      @foreach(old('row_pack') as $key_pack => $value_pack)

                        <tr>

                          <td>
                            <select name="row_pack[{{ $key_pack }}][item]" id="item_pack" class="form-control item_pack">
                              <option value="">Select</option>
                              @foreach($global_pack_mat_items_all as $data) 
                                  <option value="{{ $data->product_code }}" {!! $value_pack['item'] == $data->product_code ? 'selected' : ''!!}>{{ $data->name }}</option>
                              @endforeach
                            </select>
                            <br><small class="text-danger">{{ $errors->first('row_pack.'. $key_pack .'.item') }}</small>
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
                              @foreach($global_pack_mat_items_all as $data) 
                                  <option value="{{ $data->product_code }}" {!! $value_pack->item_pack_mat_product_code == $data->product_code ? 'selected' : ''!!}>{{ $data->name }}</option>
                              @endforeach
                            </select>
                            <br><small class="text-danger">{{ $errors->first('row_pack.'. $key_pack .'.item') }}</small>
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


    {{-- ADD RAW Mats --}}
    $(document).ready(function() {
      $("#add_row_raw").on("click", function() {
          var i = $("#table_body_raw").children().length;
          $('.item_raw').select2('destroy');
          var content ='<tr>' +

                        '<td>' +
                          '<select name="row_raw[' + i + '][item]" id="item_raw" class="form-control item_raw">' +
                            '<option value="">Select</option>' +
                            '@foreach($global_raw_mat_items_all as $data)' +
                              '<option value="{{ $data->product_code }}">{{ $data->name }}</option>' +
                            '@endforeach' +
                          '</select>' +
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




    {{-- ADD PACK Mats --}}
    $(document).ready(function() {
      $("#add_row_pack").on("click", function() {
          var i = $("#table_body_pack").children().length;
          $('.item_pack').select2('destroy');
          var content ='<tr>' +

                        '<td>' +
                          '<select name="row_pack[' + i + '][item]" id="item_pack" class="form-control item_pack">' +
                            '<option value="">Select</option>' +
                            '@foreach($global_pack_mat_items_all as $data)' +
                              '<option value="{{ $data->product_code }}">{{ $data->name }}</option>' +
                            '@endforeach' +
                          '</select>' +
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


    $('.item_raw').select2({
      dropdownParent: $('#table_body_raw')
    });


    $('.item_pack').select2({
      dropdownParent: $('#table_body_pack')
    });


  </script>
    
@endsection

