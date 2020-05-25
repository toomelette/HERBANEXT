<?php
 
  if(!empty($delivery->deliveryItem)){
    $list_of_selected_po_item = $delivery->deliveryItem->pluck('po_item_id')->toArray();
  }else{
    $list_of_selected_po_item = [];
  }
 
  if(!empty($delivery->deliveryJO)){
    $list_of_selected_jo = $delivery->deliveryJO->pluck('jo_id')->toArray();
  }else{
    $list_of_selected_jo = [];
  }

?>

@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">Edit Delivery</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
            &nbsp;
            {!! __html::back_button(['dashboard.delivery.index']) !!}
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.delivery.update', $delivery->slug) }}">

        <div class="box-body">
          <div class="col-md-12">
                  
            @csrf    

            <input name="_method" value="PUT" type="hidden">

            {!! __form::textbox(
              '3', 'delivery_code', 'text', 'Delivery Code *', 'Delivery Code', old('delivery_code') ? old('delivery_code') : $delivery->delivery_code, $errors->has('delivery_code'), $errors->first('delivery_code'), ''
            ) !!}

            {!! __form::datepicker(
              '3', 'date',  'Delivery Date *', old('date') ? old('date') : $delivery->date, $errors->has('date'), $errors->first('date')
            ) !!}

            {!! __form::textbox(
              '6', 'description', 'text', 'Description', 'Description', old('description') ? old('description') : $delivery->description, $errors->has('description'), $errors->first('description'), ''
            ) !!}

            <div class="col-md-12"></div>

            {{-- PO Items --}}
            <div class="col-md-12 no-padding">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h2 class="box-title">Purchase Order Items</h2>
                  <div class="pull-right">
                    <button class="btn btn-danger btn-sm" id="deselect_po_items">Deselect All</button>
                  </div> 
                </div>

                <div class="box-body">
                  <select name="po_items[]" id="po_items" class="form-control" multiple="multiple">

                    @foreach($global_po_items_all as $data)

                      @if(old('po_items'))

                        @if($data->isOnTheWayToClient() == true)

                          @if(in_array($data->po_item_id, $list_of_selected_po_item))
                            <option value="{{ $data->po_item_id }}" style="padding:8px;" style="padding:8px;" selected>
                          {{ 'PO No.: '.$data->po_no .' | Product Name: '. optional($data->item)->name }}
                            </option>
                          @endif

                        @elseif($data->isReadyForDelivery() == true)

                          <option value="{{ $data->po_item_id }}" 
                                  style="padding:8px;" 
                                  {!! in_array($data->po_item_id, old('po_items')) ? 'selected' : '' !!}>
                            {{ 'PO No.: '.$data->po_no .' | Product Name: '. optional($data->item)->name }}
                          </option>

                        @endif

                      @else

                        @if($data->isOnTheWayToClient() == true)

                          @if(in_array($data->po_item_id, $list_of_selected_po_item))
                            <option value="{{ $data->po_item_id }}" style="padding:8px;" style="padding:8px;" selected>
                          {{ 'PO No.: '.$data->po_no .' | Product Name: '. optional($data->item)->name }}
                            </option>
                          @endif

                        @elseif($data->isReadyForDelivery() == true)
                          
                          <option value="{{ $data->po_item_id }}" style="padding:8px;" style="padding:8px;">
                          {{ 'PO No.: '.$data->po_no .' | Product Name: '. optional($data->item)->name }}
                          </option>

                        @endif

                      @endif

                    @endforeach

                  </select>
                </div>

              </div>            
            </div>

            <div class="col-md-12"></div>

            {{-- Job Orders --}}
            <div class="col-md-12 no-padding">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h2 class="box-title">Job Orders</h2>
                  <div class="pull-right">
                    <button class="btn btn-danger btn-sm" id="deselect_po_items">Deselect All</button>
                  </div> 
                </div>

                <div class="box-body">
                  <select name="jo[]" id="jo" class="form-control" multiple="multiple">

                    @foreach($global_job_orders_all as $data)

                      @if(old('jo'))

                        @if($data->delivery_status == 2)

                          @if(in_array($data->jo_id, $list_of_selected_jo))
                            <option value="{{ $data->jo_id }}" style="padding:8px;" style="padding:8px;" selected>
                          {{ 'Batch No.: '.$data->lot_no .' | Product Name: '. optional($data->purchaseOrderItem->item)->name }}
                            </option>
                          @endif

                        @elseif($data->delivery_status == 2)

                          <option value="{{ $data->jo_id }}" 
                                  style="padding:8px;" 
                                  {!! in_array($data->jo_id, old('jo')) ? 'selected' : '' !!}>
                            {{ 'Batch No.: '.$data->lot_no .' | Product Name: '. optional($data->purchaseOrderItem->item)->name }}
                          </option>

                        @endif

                      @else

                        @if($data->delivery_status == 2)

                          @if(in_array($data->jo_id, $list_of_selected_jo))
                            <option value="{{ $data->jo_id }}" style="padding:8px;" style="padding:8px;" selected>
                          {{ 'Batch No.: '.$data->lot_no .' | Product Name: '. optional($data->purchaseOrderItem->item)->name }}
                            </option>
                          @endif

                        @elseif($data->delivery_status == 1)
                          
                          <option value="{{ $data->jo_id }}" style="padding:8px;" style="padding:8px;">
                          {{ 'Batch No.: '.$data->lot_no .' | Product Name: '. optional($data->purchaseOrderItem->item)->name }}
                          </option>

                        @endif

                      @endif

                    @endforeach

                  </select>
                </div>

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

    {{-- Multi Select PO Items--}}

    $('#deselect_po_items').click(function(){
      $('#po_items').multiSelect('deselect_all');
      return false;
    });

    $('#po_items').multiSelect({

      selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Search ..'>",
      selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Search ..'>",

      afterInit: function(ms){

        var that = 
            this,
            $selectableSearch = that.$selectableUl.prev(),
            $selectionSearch = that.$selectionUl.prev(),
            selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
            selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
        .on('keydown', function(e){
          if (e.which === 40){
            that.$selectableUl.focus();
            return false;
          }
        });

        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
        .on('keydown', function(e){
          if (e.which == 40){
            that.$selectionUl.focus();
            return false;
          }
        });

      },

      afterSelect: function(){
        this.qs1.cache();
        this.qs2.cache();
      },

      afterDeselect: function(){
        this.qs1.cache();
        this.qs2.cache();
      }

    });


    {{-- Multi Select Job Order--}}

    $('#deselect_jo').click(function(){
      $('#jo').multiSelect('deselect_all');
      return false;
    });

    $('#jo').multiSelect({

      selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Search ..'>",
      selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Search ..'>",

      afterInit: function(ms){

        var that = 
            this,
            $selectableSearch = that.$selectableUl.prev(),
            $selectionSearch = that.$selectionUl.prev(),
            selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
            selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
        .on('keydown', function(e){
          if (e.which === 40){
            that.$selectableUl.focus();
            return false;
          }
        });

        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
        .on('keydown', function(e){
          if (e.which == 40){
            that.$selectionUl.focus();
            return false;
          }
        });

      },

      afterSelect: function(){
        this.qs1.cache();
        this.qs2.cache();
      },

      afterDeselect: function(){
        this.qs1.cache();
        this.qs2.cache();
      }

    });
  
  </script>
    
@endsection