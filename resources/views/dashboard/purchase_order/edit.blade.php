@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">Edit Purchase Order</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
            &nbsp;
            {!! __html::back_button(['dashboard.purchase_order.index', 'dashboard.purchase_order.buffer']) !!}
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.purchase_order.update', $purchase_order->slug) }}">

        <div class="box-body">
          
          @csrf    

          <input name="_method" value="PUT" type="hidden">

          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">PO Number</h3>
              </div>
              <div class="box-body">

                {!! __form::textbox(
                  '3', 'po_no', 'text', 'PO Number *', 'PO Number', old('po_no') ? old('po_no') : $purchase_order->po_no, $errors->has('po_no'), $errors->first('po_no'), ''
                ) !!}  

                {!! __form::datepicker(
                  '3', 'date_required',  'Date Required *', old('date_required') ? old('date_required') : $purchase_order->date_required, $errors->has('date_required'), $errors->first('date_required')
                ) !!}

              </div>
            </div>
          </div>



          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Bill to</h3>
              </div>
              <div class="box-body">

                {!! __form::textbox(
                  '12', 'bill_to_name', 'text', 'Name *', 'Name', old('bill_to_name') ? old('bill_to_name') : $purchase_order->bill_to_name, $errors->has('bill_to_name'), $errors->first('bill_to_name'), ''
                ) !!}  

                {!! __form::textbox(
                  '12', 'bill_to_company', 'text', 'Company *', 'Company', old('bill_to_company') ? old('bill_to_company') : $purchase_order->bill_to_company, $errors->has('bill_to_company'), $errors->first('bill_to_company'), ''
                ) !!}  

                {!! __form::textbox(
                  '12', 'bill_to_address', 'text', 'Address *', 'Address', old('bill_to_address') ? old('bill_to_address') : $purchase_order->bill_to_address, $errors->has('bill_to_address'), $errors->first('bill_to_address'), ''
                ) !!}

              </div>
            </div>
          </div>



          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Ship to</h3>
                <div class="box-tools">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" class="minimal" id="fill_ship_to" value=""> &nbsp;The same as Bill to
                      </label>
                    </div>
                </div>
              </div>
              <div class="box-body">

                {!! __form::textbox(
                  '12', 'ship_to_name', 'text', 'Name *', 'Name', old('ship_to_name') ? old('ship_to_name') : $purchase_order->ship_to_name, $errors->has('ship_to_name'), $errors->first('ship_to_name'), ''
                ) !!}  

                {!! __form::textbox(
                  '12', 'ship_to_company', 'text', 'Company *', 'Company', old('ship_to_company') ? old('ship_to_company') : $purchase_order->ship_to_company, $errors->has('ship_to_company'), $errors->first('ship_to_company'), ''
                ) !!}  

                {!! __form::textbox(
                  '12', 'ship_to_address', 'text', 'Address *', 'Address', old('ship_to_address') ? old('ship_to_address') : $purchase_order->ship_to_address, $errors->has('ship_to_address'), $errors->first('ship_to_address'), ''
                ) !!}

              </div>
            </div>
          </div>





          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Others</h3>
              </div>
              <div class="box-body">

                {!! __form::textbox_numeric(
                  '6', 'freight_fee', 'text', 'Freight', 'Freight', old('freight_fee') ? old('freight_fee') : $purchase_order->freight_fee, $errors->has('freight_fee'), $errors->first('freight_fee'), ''
                ) !!}

                {!! __form::textbox_numeric(
                  '6', 'vat', 'text', 'VAT (%)', 'VAT (%)', old('vat') ? old('vat') : $purchase_order->vat, $errors->has('vat'), $errors->first('vat'), ''
                ) !!}

                {!! __form::textbox(
                  '12', 'instructions', 'text', 'Shipping/Special Instructions', 'Shipping/Special Instructions', old('instructions') ? old('instructions') : $purchase_order->instructions, $errors->has('instructions'), $errors->first('instructions'), ''
                ) !!}

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





@section('modals')

  {{-- DV CREATE SUCCESS --}}
  @if(Session::has('PURCHASE_ORDER_CREATE_SUCCESS'))

    {!! __html::modal_print(
      'po_create', '<i class="fa fa-fw fa-check"></i> Saved!', Session::get('PURCHASE_ORDER_CREATE_SUCCESS'), route('dashboard.purchase_order.show', Session::get('PURCHASE_ORDER_CREATE_SUCCESS_SLUG'))
    ) !!}

  @endif

@endsection 




@section('scripts')

  <script type="text/javascript">
  
    @if(Session::has('PURCHASE_ORDER_CREATE_SUCCESS'))
      $('#po_create').modal('show');
    @endif


    $('#fill_ship_to').on('ifChecked', function(event){
      $('#ship_to_name').val($('#bill_to_name').val());
      $('#ship_to_company').val($('#bill_to_company').val());
      $('#ship_to_address').val($('#bill_to_address').val());
    });
    

    $('#fill_ship_to').on('ifUnchecked', function(event){
      $('#ship_to_name').val('');
      $('#ship_to_company').val('');
      $('#ship_to_address').val('');
    });


    $("#freight_fee").priceFormat({
        centsLimit: 4,
        prefix: "",
        thousandsSeparator: ",",
        clearOnEmpty: true,
        allowNegative: false
    });


    $("#vat").priceFormat({
        centsLimit: 4,
        prefix: "",
        thousandsSeparator: ",",
        clearOnEmpty: true,
        allowNegative: false
    });
    
  </script>
    
@endsection