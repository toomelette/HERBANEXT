<?php
    
    function decFilter($amount){

      if ($amount > 0) {
        return number_format($amount, 3);
      }

      return '';

    }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Finishing Order</title>
	<link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/skins/_all-skins.min.css') }}">

  <style type="text/css">

    @media print {
      footer {
        page-break-after: always;
      }
    }

  </style>

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

    <div class="row">
      <div class="col-xs-12 table-responsive">

        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Product : {{ optional($finishing_order->jobOrder)->item_name }}</td>
              <td>Lot No. : {{ optional($finishing_order->jobOrder)->lot_no }}</td>
              <td>Master MO No. : {{ $finishing_order->master_fo_no }}</td>
              <td>MO No. : {{ $finishing_order->fo_no }}</td>
            </tr>
            <tr>
              <td>Product Form : {{ optional($finishing_order->jobOrder)->itemType->name }}</td>
              <td>Product Code : {{ optional($finishing_order->jobOrder)->item_product_code }}</td>
              <td>Batch Size : {{ optional($finishing_order->jobOrder)->batch_size }}</td>
              <td>JO No. : {{ optional($finishing_order->jobOrder)->jo_no }}</td>
            </tr>
            <tr>
              <td>Client : {{ $finishing_order->client }}</td>
              <td>Shelf Life : {{ $finishing_order->shelf_life }}</td>
              <td>Pack Size : {{ optional($finishing_order->jobOrder)->pack_size }}</td>
              <td>PO No. : {{ optional($finishing_order->jobOrder)->po_no }}</td>
            </tr>
            <tr>
              <td>Date of Processing : {{ __dataType::date_parse($finishing_order->processing_date, 'm/d/Y') }}</td>
              <td>Date of Expiry : {{ __dataType::date_parse($finishing_order->expired_date, 'm/d/Y') }}</td>
              <td>Requested Date : {{ __dataType::date_parse($finishing_order->requested_date, 'm/d/Y') }}</td>
              <td>Requested By : {{ $finishing_order->requested_by }}</td>
            </tr>
            <tr>
              <td>Theoritical Yield : {{ optional($finishing_order->jobOrder)->theo_yield }}</td>
              <td>Status : {{ $finishing_order->status }}</td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
        <p>Note: Any deviation in this production procedure will require Change Control approval prior to implementation.</p>

        <table class="table table-bordered">
          <thead>
          <tr>
            <th>Product Code</th>
            <th>Packaging Material</th>
            <th>Required Quantity</th>
            <th>Quantity Issued</th>
          </tr>
          </thead>
          <tbody>
            @foreach($finishing_order->finishingOrderPackMat as $data)
              <tr>
                <td>{{ $data->item_product_code }}</td>
                <td>{{ $data->item_name }}</td>
                <td>{{ decFilter($data->req_qty) .' '. $data->req_qty_unit }}</td>
                <td>{{ decFilter($data->qty_issued) .' '. $data->qty_issued_unit }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

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
                <td>{{ decFilter($data->figure_actual_usage) .' '. $data->figure_unit }}</td>
                <td>{{ decFilter($data->figure_regected) .' '. $data->figure_unit }}</td>
                <td>{{ decFilter($data->figure_damaged) .' '. $data->figure_unit }}</td>
                <td>{{ decFilter($data->figure_returns) .' '. $data->figure_unit }}</td>
                <td>{{ decFilter($data->figure_samples) .' '. $data->figure_unit }}</td>
                <td>{{ decFilter($data->figure_total) .' '. $data->figure_unit }}</td>
                <td>{{ decFilter($data->figure_difference) .' '. $data->figure_unit }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <table class="table table-bordered">
          <thead>
          <tr>
            <th>Issued by/Date:</th>
            <th>Checked by/Date:</th>
            <th>Received by/Date:</th>
          </tr>
          </thead>
          <tbody>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </section>



  <footer></footer>



  <section class="invoice">

    <div class="row" style="padding-top:10px;">
      <div class="col-xs-12">
        <h2 class="page-header">
          <img src="{{ asset('images/logo.png') }}" style="width:200px; height:70px; margin-top: -20px"> 
          <span class="pull-right" style="font-size:30px;">Finishing Order Form</span>
        </h2>
      </div>
    </div>

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
              <td>Batch Size : {{ $finishing_order->jo_batch_size }}</td>
              <td>JO No. : {{ $finishing_order->jo_no }}</td>
            </tr>
            <tr>
              <td>Client : {{ $finishing_order->client }}</td>
              <td>Shelf Life : {{ $finishing_order->shelf_life }}</td>
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

        <table class="table table-bordered">
          <thead>
          <tr>
            <th>Product Code</th>
            <th>Packaging Material</th>
            <th>Required Quantity</th>
            <th>Quantity Issued</th>
          </tr>
          </thead>
          <tbody>
            @foreach($finishing_order->finishingOrderPackMat as $data)
              <tr>
                <td>{{ $data->item_product_code }}</td>
                <td>{{ $data->item_name }}</td>
                <td>{{ decFilter($data->req_qty) .' '. $data->req_qty_unit }}</td>
                <td>{{ decFilter($data->qty_issued) .' '. $data->qty_issued_unit }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <h4>Endorsement Form</h4>
        <div class="col-xs-6">
          <span>Total # of Container/s:</span>
          &nbsp;____________________________________ 
          <br>
          <br>
          <span>Total Net Weight&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</span>
          &nbsp;____________________________________ 
        </div>
        <div class="col-xs-6">
          <span>Endorsed by/Date:</span>
          &nbsp;____________________________________ 
          <br>
          <br>
          <span>Received by/Date:</span>
          &nbsp;____________________________________ 
        </div>
      </div>
    </div>

    <div class="row" style="margin-top:30px;">
      <div class="col-xs-12 table-responsive">

        <table class="table table-bordered">
          <thead>
          <tr>
            <th>Issued by/Date:</th>
            <th>Checked by/Date:</th>
            <th>Received by/Date:</th>
          </tr>
          </thead>
          <tbody>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>

  </section>

</body>
</html>