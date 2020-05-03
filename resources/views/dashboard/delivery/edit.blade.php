<?php
 
  if(!empty($delivery->deliveryJobOrder)){
    $list_of_selected_jo = $delivery->deliveryJobOrder->pluck('jo_id')->toArray();
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

            {{-- Personnels --}}
            <div class="col-md-12 no-padding">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h2 class="box-title">Job Orders</h2>
                  <div class="pull-right">
                    <button class="btn btn-danger btn-sm" id="deselect_job_orders">Deselect All</button>
                  </div> 
                </div>

                <div class="box-body">
                  <select name="job_orders[]" id="job_orders" class="form-control" multiple="multiple">
                    @foreach($global_job_orders_all as $data)
                      @if(old('job_orders'))
                        <option value="{{ $data->jo_id }}" style="padding:8px;" {!! in_array($data->jo_id, old('job_orders')) ? 'selected' : '' !!}>
                          {{ $data->jo_no .' - '. $data->item_name }}
                        </option>
                      @else
                        @if($data->delivery_status != 1)
                          @if(in_array($data->jo_id, $list_of_selected_jo))
                            <option value="{{ $data->jo_id }}" style="padding:8px;" selected>
                              {{ $data->jo_no .' - '. $data->item_name }}
                            </option>
                          @endif
                        @else
                          <option value="{{ $data->jo_id }}" style="padding:8px;">
                            {{ $data->jo_no .' - '. $data->item_name }}
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

    {{-- Multi Select --}}

    $('#deselect_job_orders').click(function(){
      $('#job_orders').multiSelect('deselect_all');
      return false;
    });

    $('#job_orders').multiSelect({

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