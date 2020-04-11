<!DOCTYPE html>
<html>
<head>
	<title>Finishing Order</title>
	<link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/skins/_all-skins.min.css') }}">
</head>
<body onload="window.print();" onafterprint="window.close()">

	<section class="invoice">

    <div class="row" style="padding-top:10px;">
      <div class="col-xs-12">
        <h2 class="page-header">
          <img src="{{ asset('images/logo.png') }}" style="width:200px; height:70px; margin-top: -20px"> 
          <span class="pull-right" style="font-size:30px;">Finishing Order Form</span>
        </h2>
      </div>
    </div>


    {{-- Details --}}
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-bordered">
          <tbody>

            <tr>
              <td>Product : {{ $finishing_order->item_name }}</td>
              <td>Lot No. : {{ $finishing_order->lot_no }}</td>
              <td>Master MO No. : {{ $finishing_order->master_fo_no }}</td>
              <td>MO No. : {{ $finishing_order->fo_no }}</td>
            </tr>

            <tr>
              <td>Product Form : {{ optional($finishing_order->itemType)->name }}</td>
              <td>Product Code : {{ $finishing_order->item_product_code }}</td>
              <td>Batch Size : {{ number_format($finishing_order->jo_batch_size, 3) .' '. $finishing_order->jo_batch_size_unit }}</td>
              <td>JO No. : {{ $finishing_order->jo_no }}</td>
            </tr>

            <tr>
              <td>Client : {{ $finishing_order->client }}</td>
              <td>Shell Life : {{ $finishing_order->shell_life }}</td>
              <td>Pack Size : {{ number_format($finishing_order->jo_pack_size, 3) .' '. $finishing_order->jo_pack_size_unit .' / '. $finishing_order->jo_pack_size_pkging }}</td>
              <td>PO No. : {{ $finishing_order->po_no }}</td>
            </tr>

            <tr>
              <td>Date of Processing : {{ __dataType::date_parse($finishing_order->processing_date, 'm/d/Y') }}</td>
              <td>Date of Expiry : {{ __dataType::date_parse($finishing_order->expired_date, 'm/d/Y') }}</td>
              <td>Requested Date : {{ __dataType::date_parse($finishing_order->requested_date, 'm/d/Y') }}</td>
              <td>Requested By : {{ $finishing_order->requested_by }}</td>
            </tr>

            <tr>
              <td>Theoritical Yield : {{ number_format($finishing_order->jo_theo_yield, 3) .' '. $finishing_order->jo_theo_yield_pkging }}</td>
              <td>Status : {{ $finishing_order->status }}</td>
              <td></td>
              <td></td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>



    {{-- Pack Mats --}}
    <div class="row">
      <div class="col-xs-12 table-responsive">
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



    {{-- Figures --}}
    <div class="row">
      <div class="col-xs-12 table-responsive">
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

  </section>




  <section class="invoice">

    <div class="row" style="padding-top:10px;">
      <div class="col-xs-12">
        <h2 class="page-header">
          <img src="{{ asset('images/logo.png') }}" style="width:200px; height:70px; margin-top: -20px"> 
          <span class="pull-right" style="font-size:30px;">Finishing Order Form</span>
        </h2>
      </div>
    </div>


    {{-- Details --}}
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-bordered">
          <tbody>

            <tr>
              <td>Product : {{ $finishing_order->item_name }}</td>
              <td>Lot No. : {{ $finishing_order->lot_no }}</td>
              <td>Master MO No. : {{ $finishing_order->master_fo_no }}</td>
              <td>MO No. : {{ $finishing_order->fo_no }}</td>
            </tr>

            <tr>
              <td>Product Form : {{ optional($finishing_order->itemType)->name }}</td>
              <td>Product Code : {{ $finishing_order->item_product_code }}</td>
              <td>Batch Size : {{ number_format($finishing_order->jo_batch_size, 3) .' '. $finishing_order->jo_batch_size_unit }}</td>
              <td>JO No. : {{ $finishing_order->jo_no }}</td>
            </tr>

            <tr>
              <td>Client : {{ $finishing_order->client }}</td>
              <td>Shell Life : {{ $finishing_order->shell_life }}</td>
              <td>Pack Size : {{ number_format($finishing_order->jo_pack_size, 3) .' '. $finishing_order->jo_pack_size_unit .' / '. $finishing_order->jo_pack_size_pkging }}</td>
              <td>PO No. : {{ $finishing_order->po_no }}</td>
            </tr>

            <tr>
              <td>Date of Processing : {{ __dataType::date_parse($finishing_order->processing_date, 'm/d/Y') }}</td>
              <td>Date of Expiry : {{ __dataType::date_parse($finishing_order->expired_date, 'm/d/Y') }}</td>
              <td>Requested Date : {{ __dataType::date_parse($finishing_order->requested_date, 'm/d/Y') }}</td>
              <td>Requested By : {{ $finishing_order->requested_by }}</td>
            </tr>

            <tr>
              <td>Theoritical Yield : {{ number_format($finishing_order->jo_theo_yield, 3) .' '. $finishing_order->jo_theo_yield_pkging }}</td>
              <td>Status : {{ $finishing_order->status }}</td>
              <td></td>
              <td></td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>



    {{-- Parameters --}}
    <div class="row">
      <div class="col-xs-12 table-responsive">
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

  </section>

</body>
</html>