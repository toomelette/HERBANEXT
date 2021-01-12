@extends('layouts.admin-master')

@section('content')

<section class="content">
       

  {{-- Current Inventory Report --}}
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title">Current Inventory Report</h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" action="{{ route('dashboard.item.reports_output') }}">

      <div class="box-body">
        <div class="col-md-12">

            {!! __form::select_static(
              '3', 'type', 'Report Type *', old('type'), ['CURRENT INVENTORY COUNT' => '1', 'CURRENT INVENTORY COST' => '2'], $errors->has('type'), $errors->first('type'), '', ''
            ) !!}

            {!! __form::select_static(
              '3', 's', 'Scope *', old('s'), ['All' => '1', 'By Category' => '2'], $errors->has('s'), $errors->first('s'), '', ''
            ) !!}

            {!! __form::select_dynamic(
              '3', 'ic', 'Category *', old('ic'), $global_item_categories_all, 'item_category_id', 'name', $errors->has('ic'), $errors->first('ic'), 'select2', ''
            ) !!}

            {!! __form::select_static(
              '3', 'sb', 'Sort By *', old('sb'), ['A-Z' => '1', 'Highest Balance / Cost' => '2'], $errors->has('sb'), $errors->first('sb'), '', ''
            ) !!}

        </div>
      </div>

      <div class="box-footer">
        <button type="submit" class="btn btn-default">
          Print <i class="fa fa-fw fa-print"></i>
        </button>
      </div>

    </form>

  </div>



</section>

@section('scripts')

  <script type="text/javascript">

    $(document).ready(function() {
      $("#s").on("change", function() {

        if($(this).val() == '1'){
          $("#ic").prop("disabled", true);
        }else if($(this).val() == '2'){
          $("#ic").prop("disabled", false);
        }else{
          $("#ic").prop("disabled", true);
        }

      });
    });

  </script>

@endsection

@endsection