@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">New Task</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.task.store') }}">

        <div class="box-body">
          <div class="col-md-12">
                  
            @csrf    

            {!! __form::textbox(
              '6', 'name', 'text', 'Task Name *', 'Task Name', old('name'), $errors->has('name'), $errors->first('name'), ''
            ) !!}

            {!! __form::textbox(
              '6', 'description', 'text', 'Description', 'Description', old('description'), $errors->has('description'), $errors->first('description'), ''
            ) !!}

            <div class="col-md-12"></div>
            
            {!! __form::select_dynamic(
              '6', 'item_id', 'Product to be Process *', old('item_id'), $global_items_all, 'item_id', 'name', $errors->has('item_id'), $errors->first('item_id'), 'select2', ''
            ) !!}

            {!! __form::select_dynamic(
              '6', 'machine_id', 'Machine to be used *', old('machine_id'), $global_machines_all, 'machine_id', 'name', $errors->has('machine_id'), $errors->first('machine_id'), 'select2', ''
            ) !!}

            {{-- Personnels --}}
            <div class="col-md-12 no-padding">
              <div class="box box-solid">
                  
                <div class="box-header with-border">
                  <h2 class="box-title">Personnels</h2>
                  <div class="pull-right">
                    <button class="btn btn-danger btn-sm" id="deselect_personnels">Deselect All</button>
                  </div> 
                </div>

                <div class="box-body">
                  <select name="personnels[]" id="personnels" class="form-control" multiple="multiple">
                    @foreach($global_personnels_all as $data)
                      @if(old('personnels'))
                          <option value="{{ $data->personnel_id }}" {!! in_array($data->personnel_id, old('personnels')) ? 'selected' : '' !!}>{{ $data->fullname }}</option>
                      @else
                          <option value="{{ $data->personnel_id }}" style="padding:8px;">{{ $data->fullname }}</option>
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

    @if(Session::has('TASK_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('TASK_CREATE_SUCCESS')) !!}
    @endif


    {{-- Multi Select --}}

    $('#deselect_personnels').click(function(){
      $('#personnels').multiSelect('deselect_all');
      return false;
    });

    $('#personnels').multiSelect({

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