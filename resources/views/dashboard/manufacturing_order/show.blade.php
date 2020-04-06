@extends('layouts.admin-master')

@section('content')

<section class="content">
    
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title" style="padding-top: 5px;">Manufacturing Order Details</h2>
      <div class="pull-right">
          {!! __html::back_button(['dashboard.manufacturing_order.index']) !!}
      </div> 
    </div>
    <div class="box-body">
      <div class="col-md-12" style="padding-top:10px;"></div>

      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-bordered">
            <tbody>

              <tr>
                <td>Product : {{ $manufacturing_order->item_name }}</td>
                <td>Lot No. : {{ $manufacturing_order->lot_no }}</td>
                <td>Master MO No. : {{ $manufacturing_order->master_mo_no }}</td>
                <td>MO No. : {{ $manufacturing_order->mo_no }}</td>
              </tr>

              <tr>
                <td>Product Form : {{ optional($manufacturing_order->itemType)->name }}</td>
                <td>Product Code : {{ $manufacturing_order->item_product_code }}</td>
                <td>Batch Size : {{ number_format($manufacturing_order->jo_batch_size, 3) .' '. $manufacturing_order->jo_batch_size_unit }}</td>
                <td>JO No. : {{ $manufacturing_order->jo_no }}</td>
              </tr>

              <tr>
                <td>Client : {{ $manufacturing_order->client }}</td>
                <td>Shell Life : {{ $manufacturing_order->shell_life }}</td>
                <td>Pack Size : {{ number_format($manufacturing_order->jo_pack_size, 3) .' '. $manufacturing_order->jo_pack_size_unit .' / '. $manufacturing_order->jo_pack_size_pkging }}</td>
                <td>PO No. : {{ $manufacturing_order->po_no }}</td>
              </tr>

              <tr>
                <td>Date of Processing : {{ __dataType::date_parse($manufacturing_order->processing_date, 'm/d/Y') }}</td>
                <td>Date of Expiry : {{ __dataType::date_parse($manufacturing_order->expired_date, 'm/d/Y') }}</td>
                <td>Requested Date : {{ __dataType::date_parse($manufacturing_order->requested_date, 'm/d/Y') }}</td>
                <td>Requested By : {{ $manufacturing_order->requested_by }}</td>
              </tr>

              <tr>
                <td>Theoritical Yield : {{ number_format($manufacturing_order->jo_theo_yield, 3) .' '. $manufacturing_order->jo_theo_yield_pkging }}</td>
                <td>Status : {{ $manufacturing_order->status }}</td>
                <td></td>
                <td></td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>



        <div class="row">
          <div class="col-xs-12 table-responsive">
          <h4>Raw Materials:</h4>
            <table class="table table-bordered">
              <thead>
              <tr>
                <th>Product Code</th>
                <th>Raw Material</th>
                <th>Required Quantity</th>
                <th>Batch No.</th>
                <th>Weight by / Date</th>
              </tr>
              </thead>
              <tbody>
                @foreach($manufacturing_order->manufacturingOrderRawMat as $data)
                  <tr>
                    <td>{{ $data->item_product_code }}</td>
                    <td>{{ $data->item_name }}</td>
                    <td>{{ number_format($data->req_qty, 3) .' '. $data->req_qty_unit }}</td>
                    <td>{{ $data->batch_no }}</td>
                    <td>{{ $data->weighed_by }}</td>
                  </tr>
                @endforeach
                  <tr>
                    <td></td>
                    <td>Total:</td>
                    <td>{{ $manufacturing_order->total_weight }}</td>
                    <td></td>
                    <td></td>
                  </tr>
              </tbody>
            </table>
          </div>

        </div>

      <div class="row no-print">
        <div class="col-xs-12">
          <a href="{{ route('dashboard.manufacturing_order.print', $manufacturing_order->slug) }}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>

    </div>
  </div>

</section>


@endsection