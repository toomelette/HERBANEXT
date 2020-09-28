@extends('layouts.admin-master')

@section('content')


<section class="content">
    
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title" style="padding-top: 5px;">Delivery Details</h2>
      <div class="pull-right">
          {!! __html::back_button(['dashboard.delivery.index']) !!}
      </div> 
    </div>
    <div class="box-body">
      <div class="col-md-12" style="padding-top:10px;"></div>
      <div class="row invoice-info">

        <div class="col-sm-12 invoice-col">
          <address>
            Delivery Code: <b>{{ $delivery->delivery_code }}</b><br>
            Delivery Date: {{ __dataType::date_parse($delivery->date, 'F d, Y') }}<br>
            Description : {{ $delivery->description }}<br>
          </address>
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
                <th>Quantity</th>
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
                <th>Quantity</th>
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


      <div class="row no-print">
        <div class="col-xs-12">
          <a href="{{ route('dashboard.delivery.print', $delivery->slug) }}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>

    </div>
  </div>

</section>


@endsection