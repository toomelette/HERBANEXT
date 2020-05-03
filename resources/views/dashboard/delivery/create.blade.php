@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">New Delivery</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.delivery.store') }}">

        <div class="box-body">
          <div class="col-md-12">
                  
            @csrf    

            {!! __form::textbox(
              '3', 'delivery_code', 'text', 'Delivery Code *', 'Delivery Code', old('delivery_code'), $errors->has('delivery_code'), $errors->first('delivery_code'), ''
            ) !!}

            {!! __form::datepicker(
              '3', 'date',  'Delivery Date *', old('date') , $errors->has('date'), $errors->first('date')
            ) !!}

            {!! __form::textbox(
              '6', 'description', 'text', 'Description', 'Description', old('description'), $errors->has('description'), $errors->first('description'), ''
            ) !!}

            <div class="col-md-12"></div>

            {{-- Personnels --}}
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

                        <option value="{{ $data->po_item_id }}" 
                                style="padding:8px;" 
                                {!! in_array($data->po_item_id, old('po_items')) ? 'selected' : '' !!}>
                          {{ $data->po_no .' - '. optional($data->item)->name }}
                        </option>

                      @else

                        @if($data->delivery_status == 1)

                          @if(optional($data->purchaseOrder)->type == 1 && $data->isReadyForDelivery() == true)
                            <option value="{{ $data->po_item_id }}" style="padding:8px;" style="padding:8px;">
                              {{ $data->po_no .' - '. optional($data->item)->name }}<br>
                            </option>
                          @endif
                        
                          @if(optional($data->purchaseOrder)->type == 2)
                            <option value="{{ $data->po_item_id }}" style="padding:8px;" style="padding:8px;">
                              {{ $data->po_no .' - '. optional($data->item)->name }}<br>
                            </option>
                          @endif
                          
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

    @if(Session::has('DELIVERY_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('DELIVERY_CREATE_SUCCESS')) !!}
    @endif


    {{-- Multi Select --}}

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
  
  </script>
    
@endsection