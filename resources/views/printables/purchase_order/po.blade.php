<?php
  
  $vat_rounded_off = $purchase_order->vat / 100;
  $vatable = $purchase_order->subtotal_price * $vat_rounded_off;

?>

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
              <span class="pull-right" style="font-size:30px;">Purchase Order Form</span>
            </h2>
          </div>
        </div>

        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            Bill to
            <address>
              <strong>{{ $purchase_order->bill_to_name }}</strong><br>
              {{ $purchase_order->bill_to_company }}<br>
              {{ $purchase_order->bill_to_address }}<br>
            </address>
          </div>

          <div class="col-sm-4 invoice-col">
            Ship to
            <address>
              <strong>{{ $purchase_order->ship_to_name }}</strong><br>
              {{ $purchase_order->ship_to_company }}<br>
              {{ $purchase_order->ship_to_address }}<br>
            </address>
          </div>

          <div class="col-sm-4 invoice-col">
            <b>PO Number:</b> {{ $purchase_order->po_no }}<br>
            <b>Date Encoded:</b> {{ __dataType::date_parse($purchase_order->created_at, 'm/d/Y') }}<br>
            <b>Date Required:</b> {{ __dataType::date_parse($purchase_order->date_required, 'm/d/Y') }}<br>
            <b>Process Status: </b>{!! $purchase_order->displayProcessStatusText() !!}<br>
          </div>

        </div>



        <div class="row">
          <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
              <thead>
              <tr>
                <th>Item No.</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Line Total</th>
              </tr>
              </thead>
              <tbody>
                @foreach($purchase_order->purchaseOrderItem as $key => $data)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ optional($data->item)->name }}</td>
                    <td>
                      @if($data->unit != 'PCS')
                        <span>{{ number_format($data->amount, 3) }} {{ $data->unit }}<span>
                      @else
                        <span>{{ number_format($data->amount) }} {{ $data->unit }}<span>
                      @endif
                    </td>
                    <td>&#8369; {{ number_format($data->item_price, 4) }}</td>
                    <td>&#8369; {{ number_format($data->line_price, 4) }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>


        <div class="row">

          <div class="col-xs-6">
            <span>Shipping / Special Instructions: </span>
            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
              {{ $purchase_order->instructions }}
            </p>
          </div>

          <div class="col-xs-6">
            <p class="lead">Amount</p>

            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th style="width:50%">Subtotal:</th>
                  <td>&#8369; {{ number_format($purchase_order->subtotal_price, 4) }}</td>
                </tr>
                <tr>
                  <th>VAT ({{ number_format($purchase_order->vat, 4) }} %)</th>
                  <td>&#8369; {{ number_format($vatable, 4) }}</td>
                </tr>
                <tr>
                  <th>Freight:</th>
                  <td>&#8369; {{ number_format($purchase_order->freight_fee, 4) }}</td>
                </tr>
                <tr>
                  <th>Total:</th>
                  <td><b>&#8369; {{ number_format($purchase_order->total_price, 4) }}</b></td>
                </tr>
              </table>
            </div>
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