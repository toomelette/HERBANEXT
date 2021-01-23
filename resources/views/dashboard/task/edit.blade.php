<?php
 
  if(!empty($task->taskPersonnel)){
    $list_of_selected_personnels = $task->taskPersonnel->pluck('personnel_id')->toArray();
  }else{
    $list_of_selected_personnels = [];
  }

?>

@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">Edit Task</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
            &nbsp;
            {!! __html::back_button(['dashboard.task.index']) !!}
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.task.update', $task->slug) }}">

        <div class="box-body">
          <div class="col-md-12">
                  
            @csrf    

            <input name="_method" value="PUT" type="hidden">

            {!! __form::textbox(
              '6', 'name', 'text', 'Task Name *', 'Task Name', old('name') ? old('name') : $task->name, $errors->has('name'), $errors->first('name'), ''
            ) !!}

            {!! __form::textbox(
              '6', 'description', 'text', 'Description', 'Description', old('description') ? old('description') : $task->description, $errors->has('description'), $errors->first('description'), ''
            ) !!}

            <div class="col-md-12"></div>
            
            {!! __form::select_dynamic(
              '6', 'item_id', 'Product to be Processed', old('item_id') ? old('item_id') : $task->item_id, $global_items_all, 'item_id', 'name', $errors->has('item_id'), $errors->first('item_id'), 'select2', ''
            ) !!}

            {!! __form::select_dynamic(
              '6', 'machine_id', 'Machine to be used *', old('machine_id') ? old('machine_id') : $task->machine_id, $global_machines_all, 'machine_id', 'name', $errors->has('machine_id'), $errors->first('machine_id'), 'select2', ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::datepicker(
              '3', 'date_from',  'Date From *', old('date_from') ? old('date_from') : __dataType::date_parse($task->date_from, 'm/d/Y'), $errors->has('date_from'), $errors->first('date_from')
            ) !!}

            {!! __form::timepicker(
              '3', 'time_from',  'Time From *', old('time_from') ? old('time_from') : date('h:i A', strtotime($task->date_from)), $errors->has('time_from'), $errors->first('time_from')
            ) !!}

            {!! __form::datepicker(
              '3', 'date_to',  'Date To *', old('date_to') ? old('date_to') : __dataType::date_parse($task->date_to, 'm/d/Y'), $errors->has('date_to'), $errors->first('date_to')
            ) !!}

            {!! __form::timepicker(
              '3', 'time_to',  'Time To *', old('time_to') ?  old('time_to') : date('h:i A', strtotime($task->date_to)), $errors->has('time_to'), $errors->first('time_to')
            ) !!}

            <div class="col-md-12"></div>

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
                          <option value="{{ $data->personnel_id }}" style="padding:8px;" {!! in_array($data->personnel_id, old('personnels')) ? 'selected' : '' !!}>{{ $data->fullname }}</option>
                      @else
                          <option value="{{ $data->personnel_id }}" style="padding:8px;" {!! in_array($data->personnel_id, $list_of_selected_personnels) ? 'selected' : '' !!}>{{ $data->fullname }}</option>
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