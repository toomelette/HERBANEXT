<!DOCTYPE html>
<html>
<head>
	<title>Manufacturing Order</title>
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
          <span class="pull-right" style="font-size:30px;">Manufacturing Order Form</span>
        </h2>
      </div>
    </div>


    {{-- Details --}}
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-bordered">
          <tbody>

            <tr>
              <td>Product : {{ optional($manufacturing_order->jobOrder)->item_name }}</td>
              <td>Lot No. : {{ optional($manufacturing_order->jobOrder)->lot_no }}</td>
              <td>Master MO No. : {{ $manufacturing_order->master_mo_no }}</td>
              <td>MO No. : {{ $manufacturing_order->mo_no }}</td>
            </tr>

            <tr>
              <td>Product Form : {{ optional($manufacturing_order->jobOrder)->itemType->name }}</td>
              <td>Product Code : {{ optional($manufacturing_order->jobOrder)->item_product_code }}</td>
              <td>Batch Size : {{ optional($manufacturing_order->jobOrder)->batch_size }}</td>
              <td>JO No. : {{ optional($manufacturing_order->jobOrder)->jo_no }}</td>
            </tr>

            <tr>
              <td>Client : {{ $manufacturing_order->client }}</td>
              <td>Shelf Life : {{ $manufacturing_order->shelf_life }}</td>
              <td>Pack Size : {{ optional($manufacturing_order->jobOrder)->pack_size }}</td>
              <td>PO No. : {{ optional($manufacturing_order->jobOrder)->po_no }}</td>
            </tr>

            <tr>
              <td>Date of Processing : {{ __dataType::date_parse($manufacturing_order->processing_date, 'm/d/Y') }}</td>
              <td>Date of Expiry : {{ __dataType::date_parse($manufacturing_order->expired_date, 'm/d/Y') }}</td>
              <td>Requested Date : {{ __dataType::date_parse($manufacturing_order->requested_date, 'm/d/Y') }}</td>
              <td>Requested By : {{ $manufacturing_order->requested_by }}</td>
            </tr>

            <tr>
              <td>Theoritical Yield : {{ optional($manufacturing_order->jobOrder)->theo_yield }}</td>
              <td>Status : {{ $manufacturing_order->status }}</td>
              <td></td>
              <td></td>
            </tr>

          </tbody>
        </table>
        <p>Note: Any deviation in this production procedure will require Change Control approval prior to implementation.</p>
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

  </section>

</body>
</html>