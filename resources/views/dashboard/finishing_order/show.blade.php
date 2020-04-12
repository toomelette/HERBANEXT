@extends('layouts.admin-master')

@section('content')

<section class="content">
    
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title" style="padding-top: 5px;">Finishing Order Details</h2>
      <div class="pull-right">
          {!! __html::back_button(['dashboard.finishing_order.index']) !!}
      </div> 
    </div>
    <div class="box-body">
      <div class="col-md-12" style="padding-top:10px;"></div>

      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-bordered">
            <tbody>

              <tr>
                <td>Product : {{ $finishing_order->item_name }}</td>
                <td>Lot No. : {{ $finishing_order->lot_no }}</td>
                <td>Master FO No. : {{ $finishing_order->master_fo_no }}</td>
                <td>FO No. : {{ $finishing_order->fo_no }}</td>
              </tr>

              <tr>
                <td>Product Form : {{ optional($finishing_order->itemType)->name }}</td>
                <td>Product Code : {{ $finishing_order->item_product_code }}</td>
                <td>Batch Size : {{ $finishing_order->jo_batch_size }}</td>
                <td>JO No. : {{ $finishing_order->jo_no }}</td>
              </tr>

              <tr>
                <td>Client : {{ $finishing_order->client }}</td>
                <td>Shell Life : {{ $finishing_order->shell_life }}</td>
                <td>Pack Size : {{ $finishing_order->jo_pack_size }}</td>
                <td>PO No. : {{ $finishing_order->po_no }}</td>
              </tr>

              <tr>
                <td>Date of Processing : {{ __dataType::date_parse($finishing_order->processing_date, 'm/d/Y') }}</td>
                <td>Date of Expiry : {{ __dataType::date_parse($finishing_order->expired_date, 'm/d/Y') }}</td>
                <td>Requested Date : {{ __dataType::date_parse($finishing_order->requested_date, 'm/d/Y') }}</td>
                <td>Requested By : {{ $finishing_order->requested_by }}</td>
              </tr>

              <tr>
                <td>Theoritical Yield : {{ $finishing_order->jo_theo_yield }}</td>
                <td>Status : {{ $finishing_order->status }}</td>
                <td></td>
                <td></td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>



      <div class="row">
        <div class="col-xs-12 table-responsive">
        <h4>Packaging Materials:</h4>
          <table class="table table-bordered">
            <thead>
            <tr>
              <th>Product Code</th>
              <th>Raw Material</th>
              <th>Required Quantity</th>
              <th>Quantity Issued</th>
            </tr>
            </thead>
            <tbody>
              @foreach($finishing_order->finishingOrderPackMat as $data)
                <tr>
                  <td>{{ $data->item_product_code }}</td>
                  <td>{{ $data->item_name }}</td>
                  <td>{{ number_format($data->req_qty, 3) .' '. $data->req_qty_unit }}</td>
                  <td>{{ number_format($data->qty_issued, 3) .' '. $data->qty_issued_unit }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>



      <div class="row">
        <div class="col-xs-12 table-responsive">
        <h4>Figures:</h4>
          <table class="table table-bordered">
            <thead>
            <tr>
              <th>Product Code</th>
              <th>Actual Usage</th>
              <th>Regected</th>
              <th>Damaged</th>
              <th>Returns</th>
              <th>Samples</th>
              <th>Total</th>
              <th>Difference</th>
            </tr>
            </thead>
            <tbody>
              @foreach($finishing_order->finishingOrderPackMat as $data)
                <tr>
                  <td>{{ $data->item_product_code }}</td>
                  <td>{{ number_format($data->figure_actual_usage, 3) .' '. $data->figure_unit }}</td>
                  <td>{{ number_format($data->figure_regected , 3) .' '. $data->figure_unit }}</td>
                  <td>{{ number_format($data->figure_damaged  , 3) .' '. $data->figure_unit }}</td>
                  <td>{{ number_format($data->figure_returns, 3) .' '. $data->figure_unit }}</td>
                  <td>{{ number_format($data->figure_samples, 3) .' '. $data->figure_unit }}</td>
                  <td>{{ number_format($data->figure_total, 3) .' '. $data->figure_unit }}</td>
                  <td>{{ number_format($data->figure_difference, 3) .' '. $data->figure_unit }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>


      <div class="row no-print">
        <div class="col-xs-12">
          <a href="{{ route('dashboard.finishing_order.print', $finishing_order->slug) }}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>

    </div>
  </div>

</section>


@endsection