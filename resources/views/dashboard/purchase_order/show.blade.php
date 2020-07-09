<?php
  
  $vat_rounded_off = $purchase_order->vat / 100;
  $vatable = $purchase_order->subtotal_price * $vat_rounded_off;

?>

@extends('layouts.admin-master')

@section('content')


<section class="content">
    
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title" style="padding-top: 5px;">Purchase Order Details</h2>
      <div class="pull-right">
          {!! __html::back_button(['dashboard.purchase_order.index', 'dashboard.purchase_order.buffer']) !!}
      </div> 
    </div>
    <div class="box-body">
      <div class="col-md-12" style="padding-top:10px;"></div>
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
          <table class="table table-bordered">
            <thead>
            <tr>
              <th>Item No.</th>
              <th>Item Name</th>
              <th>Raw Mats</th>
              <th>Pack Mats</th>
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
                    @foreach($data->purchaseOrderItemRawMat as $data_poirm)
                      <li>{{ $data_poirm->name }}</li>
                    @endforeach
                  </td>
                  <td>
                    @foreach($data->purchaseOrderItemPackMat as $data_poipm)
                      <li>{{ $data_poipm->name }}</li>
                    @endforeach
                  </td>
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
          <p class="lead">Quantity</p>

          <div class="table-responsive">
            <table class="table table-bordered">
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
          <a href="{{ route('dashboard.purchase_order.print', $purchase_order->slug) }}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>

    </div>
  </div>

</section>


@endsection