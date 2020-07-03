@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title"  style="padding-top: 5px;">Check Out specific batch</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
            &nbsp;
            <a href="{{ route('dashboard.item.fetch_logs_by_item', $item->slug) }}" type="button" class="btn btn-sm btn-default">
              <i class="fa fa-fw fa-file-text-o"></i> View logs
            </a>
            &nbsp;
            <a href="{{ route('dashboard.item.fetch_batch_by_item', $item->slug) }}" type="button" class="btn btn-sm btn-default"><i class="fa fa-fw fa-cubes"></i> View Batches</a>
            &nbsp;
            <a href="{{ route('dashboard.item.index') }}" type="button" class="btn btn-sm btn-default"><i class="fa fa-fw fa-arrow-left"></i> Back to List</a>
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.item.check_out_by_batch_post', $item->slug) }}">

        <div class="box-body">

          @if(Session::has('ITEM_INSUFFICIENT_BALANCE'))
            {!! __html::alert('danger', '<i class="icon fa fa-ban"></i> Warning!', Session::get('ITEM_INSUFFICIENT_BALANCE')) !!}
          @endif

          <div class="col-md-12">
            <span>Item: {{ $item->name }}</span></b>
            @if($item->unit != 'PCS')
              <p>Remaining Balance: {{ number_format($item->current_balance, 3) .' '. $item->unit}}</p></b>
            @else
              <p>Remaining Balance: {{ number_format($item->current_balance) .' '. $item->unit}}</p></b>
            @endif
          </div>

          @csrf  

          {!! __form::select_dynamic(
            '4', 'batch_code', 'Batch Code *', old('batch_code'), $item_batches, 'batch_code', 'batch_code', $errors->has('batch_code'), $errors->first('batch_code'), 'select2', ''
          ) !!}       

          {!! __form::textbox_numeric(
            '4', 'amount', 'text', 'Quantity *', 'Quantity', old('amount'), $errors->has('amount'), $errors->first('amount'), ''
          ) !!}

          {!! __form::select_static(
            '4', 'unit', 'Standard Unit *', old('unit'), [], $errors->has('unit'), $errors->first('unit'), '', ''
          ) !!} 

          {!! __form::textbox(
           '12', 'remarks', 'text', 'Remarks', 'Remarks', old('remarks'), $errors->has('remarks'), $errors->first('remarks'), ''
          ) !!}     

        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-default">Check Out <i class="fa fa-fw fa-minus"></i></button>
        </div>

      </form>

    </div>

</section>

@endsection



@section('scripts')

  <script type="text/javascript">

    @if($item->unit_type_id == 'IU1001')
      $("#unit").empty();
      $("#unit").append("<option value='PCS'{{ old('unit') == 'PCS' ? 'selected' : '' }}>PCS</option>");
      $("#amount").priceFormat({
          centsLimit: 0,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });
    @elseif($item->unit_type_id == 'IU1002')
      $("#unit").empty();
      $("#unit").append("<option value>Select</option>");
      $("#unit").append("<option value='GRAM' {{ old('unit') == 'GRAM' ? 'selected' : '' }}>GRAMS</option>");
      $("#unit").append("<option value='KILOGRAM' {{ old('unit') == 'KILOGRAM' ? 'selected' : '' }}>KILOGRAMS</option>");
      $("#amount").priceFormat({
          centsLimit: 3,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });
    @elseif($item->unit_type_id == 'IU1003')
      $("#unit").empty();
      $("#unit").append("<option value>Select</option>");
      $("#unit").append("<option value='MILLILITRE' {{ old('unit') == 'MILLILITRE' ? 'selected' : '' }}>MILLILITERS</option>");
      $("#unit").append("<option value='LITRE' {{ old('unit') == 'LITRE' ? 'selected' : '' }}>LITERS</option>");
      $("#amount").priceFormat({
          centsLimit: 3,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });
    @else
      $("#unit").empty();
      $("#amount").priceFormat({
          centsLimit: 0,
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: false
      });
    @endif

    @if(Session::has('ITEM_CHECK_OUT_SUCCESS'))
      {!! __js::toast(Session::get('ITEM_CHECK_OUT_SUCCESS')) !!}
    @endif

  </script>
    
@endsection

