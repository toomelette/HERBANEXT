<?php

  $table_sessions = [ Session::get('ITEM_UPDATE_SUCCESS_SLUG') ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>





@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Item List</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.item.index') }}">

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.item.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('product_code', 'Product Code')</th>
            <th>@sortablelink('itemCategory.name', 'Category')</th>
            <th>@sortablelink('name', 'Name')</th>
            <th>@sortablelink('', 'Balance')</th>
            <th>@sortablelink('price', 'Price')</th>
            <th style="width: 300px">Action</th>
          </tr>
          @foreach($items as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ $data->product_code }}</td>
              <td id="mid-vert">{{ optional($data->itemCategory)->name }}</td>
              <td id="mid-vert">{{ $data->name }}</td>
              <td id="mid-vert">
                  @if($data->unit_type_id == "IU1001")
                    @if($data->min_req_qty > $data->quantity)
                      <span class="text-red">{{ number_format($data->quantity) .' PCS'}}<span>
                    @else
                      <span class="text-green">{{ number_format($data->quantity) .' PCS'}}<span>
                    @endif
                  @elseif($data->unit_type_id == "IU1002")
                    @if($data->min_req_qty > $data->weight)
                      <span class="text-red">{{ number_format($data->weight, 3) .' '. $data->weight_unit }}<span>
                    @else
                      <span class="text-green">{{ number_format($data->weight, 3) .' '. $data->weight_unit }}<span>
                    @endif
                  @elseif($data->unit_type_id == "IU1003")
                    @if($data->min_req_qty > $data->volume)
                      <span class="text-red">{{ number_format($data->volume, 3) .' '. $data->volume_unit }}<span>
                    @else
                      <span class="text-green">{{ number_format($data->volume, 3) .' '. $data->volume_unit }}<span>
                    @endif
                  @endif
              </td>
              <td id="mid-vert">
                @if($data->unit_type_id == "IU1001")
                  &#8369; {{ number_format($data->price) .' / PCS' }}
                @elseif($data->unit_type_id == "IU1002")
                  &#8369; {{ number_format($data->price) .' / '. $data->weight_unit }}
                @elseif($data->unit_type_id == "IU1003")
                  &#8369; {{ number_format($data->price) .' / '. $data->volume_unit }}
                @endif
              </td>
              <td id="mid-vert">
                <div class="btn-group">
                  <a href="#" 
                     id="check_in_btn" 
                     es="{{ $data->slug }}" 
                     data-url="{{ route('dashboard.item.check_in_post',$data->slug) }}"
                     data-unit-type-id="{{ $data->unit_type_id }}"  
                     class="btn btn-default">
                     Check-In
                  </a>
                  <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.item.edit', $data->slug) }}">
                    <i class="fa fa-pencil"></i></a>
                  <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.item.destroy', $data->slug) }}">
                    <i class="fa fa-trash"></i>
                  </a>
                </div>
              </td>
            </tr>
            @endforeach
          </table>
      </div>

      @if($items->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($items) !!}
        {!! $items->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

@endsection





@section('modals')


  {!! __html::modal_delete('item_delete') !!} 

  {{-- Check In Modal --}}
  <div class="modal fade bs-example-modal-lg" id="check_in" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"> Check In Item</h4>
        </div>
        <div class="modal-body" id="check_in_body">
          <form data-pjax id="check_in_form" method="POST" autocomplete="off">

            <div class="row">
                
              @csrf

              <input name="_method" value="PUT" type="hidden">

              {!! __form::textbox(
               '4', 'batch_code', 'text', 'Batch Code *', 'Batch Code', old('batch_code'), $errors->has('batch_code'), $errors->first('batch_code'), 'required'
              ) !!}

              <div class="col-md-8 no-padding" id="weight_div">

                {!! __form::textbox_numeric(
                  '6', 'weight', 'text', 'Weight', 'Weight', old('weight'), $errors->has('weight'), $errors->first('weight'), ''
                ) !!}

                {!! __form::select_static(
                  '6', 'weight_unit', 'Weight Unit', old('weight_unit'), ['KILOGRAM' => 'KG', 'GRAM' => 'G'], $errors->has('weight_unit'), $errors->first('weight_unit'), '', ''
                ) !!}

              </div>
              
              <div class="col-md-8 no-padding" id="volume_div">

                {!! __form::textbox_numeric(
                  '6', 'volume', 'text', 'Volume', 'Volume', old('volume'), $errors->has('volume'), $errors->first('volume'), ''
                ) !!}

                {!! __form::select_static(
                  '6', 'volume_unit', 'Volume Unit', old('volume_unit'), ['LITERS' => 'L', 'MILLILITERS' => 'ML'], $errors->has('volume_unit'), $errors->first('volume_unit'), '', ''
                ) !!}

              </div>
              
              <div class="col-md-4 no-padding" id="qty_div">

                {!! __form::textbox_numeric(
                  '12', 'quantity', 'text', 'Quantity', 'Quantity', old('quantity'), $errors->has('quantity'), $errors->first('quantity'), ''
                ) !!} 

              </div>

            </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-default">Save Changes <i class="fa fa-fw fa-save"></i></button>
        </div>
        </form>
      </div>
    </div>
  </div>


@endsection 





@section('scripts')

  <script type="text/javascript">


    // Check in
    $(document).on("click", "#check_in_btn", function () {

      $("#check_in").modal("show");
      $("#check_in_body #check_in_form").attr("action", $(this).data("url"));

      $('#batch_code').val('');
      $('#quantity').val('');
      $('#weight').val('');
      $('#weight_unit').val('');
      $('#volume').val('');
      $('#volume_unit').val('');
      
      if($(this).data("unit-type-id") == "IU1001"){ 
        $('#qty_div').show();
        $('#weight_div').hide();
        $('#volume_div').hide();
      }else if($(this).data("unit-type-id") == "IU1002"){
        $('#qty_div').hide();
        $('#weight_div').show();
        $('#volume_div').hide();
      }else if($(this).data("unit-type-id") == "IU1003"){
        $('#qty_div').hide();
        $('#weight_div').hide();
        $('#volume_div').show();
      }else{
        $('#qty_div').hide();
        $('#weight_div').hide();
        $('#volume_div').hide();
      }

      // Price Format
      $("#quantity").priceFormat({
          centsLimit: 0,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });

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

    });


    {{-- CALL CONFIRM DELETE MODAL --}}
    {!! __js::button_modal_confirm_delete_caller('item_delete') !!}


    {{-- UPDATE TOAST --}}
    @if(Session::has('ITEM_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('ITEM_UPDATE_SUCCESS')) !!}
    @endif


    {{-- DELETE TOAST --}}
    @if(Session::has('ITEM_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('ITEM_DELETE_SUCCESS')) !!}
    @endif


  </script>
    
@endsection