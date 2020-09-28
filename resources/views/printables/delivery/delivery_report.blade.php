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



    <div class="row">
      <div class="col-xs-12 table-responsive">
        <h3>Purchase Order Items</h3>
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

              @isset ($data->purchaseOrderItem)

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
                    {{ number_format(optional($data->purchaseOrderItem)->amount, 3) .' '. optional($data->purchaseOrderItem)->unit }}
                  </td>
                </tr>

              @endisset

            @endforeach
          </tbody>
        </table>
      </div>

    </div>



    <div class="row">
      <div class="col-xs-12 table-responsive">
        <h3>Job Orders</h3>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>PO No</th>
              <th>JO No</th>
              <th>Bill to</th>
              <th>Ship to</th>
              <th>Batch No</th>
              <th>Product Name</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
            @foreach($delivery->deliveryJO as $data)

              @isset ($data->jobOrder)

                <tr>
                  <td>{{ optional($data->jobOrder)->po_no }}</td>
                  
                  <td>{{ optional($data->jobOrder)->jo_no }}</td>

                  <td id="mid-vert">
                    <b>{{ optional($data->jobOrder)->purchaseOrder->bill_to_name }}</b><br>
                    {{ optional($data->jobOrder)->purchaseOrder->bill_to_company }}<br>
                    {{ optional($data->jobOrder)->purchaseOrder->bill_to_address }}<br>
                  </td>

                  <td id="mid-vert">
                    <b>{{ optional($data->jobOrder)->purchaseOrder->ship_to_name }}</b><br>
                    {{ optional($data->jobOrder)->purchaseOrder->ship_to_company }}<br>
                    {{ optional($data->jobOrder)->purchaseOrder->ship_to_address }}<br>
                  </td>

                  <td>{{ optional($data->jobOrder)->lot_no }}</td>
                  <td>{{ optional($data->jobOrder->item)->name }}</td>
                  <td>
                    {{ number_format(optional($data->jobOrder)->amount, 3) .' '. optional($data->jobOrder)->unit }}
                  </td>
                </tr>
                  
              @endisset

            @endforeach
          </tbody>
        </table>
      </div>
    </div>


    <div class="col-xs-12" style="margin-top:40px;">

      <div class="col-xs-5 no-padding">Issued by:</div>
      <div class="col-xs-2 no-padding"></div>
      <div class="col-xs-5 no-padding">Recieved by:</div>

      <div class="col-md-12" style="margin-top:70px;"></div>

      <div class="col-xs-5" style="border-bottom: solid 1px;"></div>
      <div class="col-xs-2"></div>
      <div class="col-xs-5" style="border-bottom: solid 1px;"></div>

      <div class="col-xs-5" style="text-align:center;">Signature over Printer Name</div>
      <div class="col-xs-2"></div>
      <div class="col-xs-5" style="text-align:center;">Signature over Printer Name</div>
    </div>

    <div class="row no-print">
      <div class="col-xs-12">
        <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
      </div>
    </div>

  </section>

</body>
</html>