<!DOCTYPE html>
<html>
<head>
	<title>Purchase Order</title>
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
          <span class="pull-right" style="font-size:30px;">Delivery Report</span>
        </h2>
      </div>
    </div>

    <div class="row invoice-info">

      <div class="col-sm-4 invoice-col">
        <b>Delivery Code:</b> {{ $delivery->delivery_code }}<br>
        <b>Date:</b> {{ __dataType::date_parse($delivery->date, 'm/d/Y') }}<br>
        <b>Description: </b>{!! $delivery->description !!}<br>
      </div>

    </div>



    <div class="row" style="padding-top:10px;">
      <div class="col-xs-12 table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>PO No</th>
              <th>Bill to</th>
              <th>Ship to</th>
              <th>Product Code</th>
              <th>Product Name</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
            @foreach($delivery->deliveryItem as $data)
              <tr>
                <td>{{ optional($data->purchaseOrderItem)->po_no }}</td>

                <td id="mid-vert">
                  <b>{{ optional($data->purchaseOrderItem)->purchaseOrder->bill_to_name }}</b><br>
                  {{ optional($data->purchaseOrderItem)->purchaseOrder->bill_to_company }}<br>
                  {{ optional($data->purchaseOrderItem)->purchaseOrder->bill_to_address }}<br>
                </td>

                <td id="mid-vert">
                  <b>{{ optional($data->purchaseOrderItem)->purchaseOrder->ship_to_name }}</b><br>
                  {{ optional($data->purchaseOrderItem)->purchaseOrder->ship_to_company }}<br>
                  {{ optional($data->purchaseOrderItem)->purchaseOrder->ship_to_address }}<br>
                </td>

                <td>{{ optional($data->purchaseOrderItem->item)->product_code }}</td>
                <td>{{ optional($data->purchaseOrderItem->item)->name }}</td>
                <td>
                  {{ optional($data->purchaseOrderItem)->amount .' '. optional($data->purchaseOrderItem)->unit }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>

    <div class="row no-print">
      <div class="col-xs-12">
        <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
      </div>
    </div>

  </section>

</body>
</html>