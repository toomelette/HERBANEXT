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
              '4', 'name', 'text', 'Task Name *', 'Task Name', old('name'), $errors->has('name'), $errors->first('name'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'description', 'text', 'Description', 'Description', old('description'), $errors->has('description'), $errors->first('description'), ''
            ) !!}

            {!! __form::select_dynamic(
              '4', 'item_id', 'Product to be Process *', old('item_id'), $global_items_all, 'item_id', 'name', $errors->has('item_id'), $errors->first('item_id'), 'select2', ''
            ) !!}
            <div class="col-md-12">
              <select id="my-select" name="my-select[]" multiple="multiple">
                <option value='elem_1'>elem 1</option>
                <option value='elem_2'>elem 2</option>
                <option value='elem_3'>elem 3</option>
                <option value='elem_4'>elem 4</option>
                <option value='elem_100'>elem 100</option>
              </select>
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

    $('#my-select').multiSelect()
  
  </script>
    
@endsection