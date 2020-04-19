<?php
  
  $list_of_keys = [

    0 => 5,
    6 => 11,
    12 => 17,
    18 => 23,
    24 => 29,
    30 => 36

  ];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Purchase Order</title>
	<link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/skins/_all-skins.min.css') }}">

  <style type="text/css">

    table {
      width: 460px;
    }
    
    table, th, td {
      border: 1px solid black;
      font-size: 10px;
    }

    th, td {
      padding: 3px;
      text-align: left;
    }

    @media print {
      footer {
        page-break-after: always;
      }
    }

  </style>

</head>
<body onload="window.print();" onafterprint="window.close()">

	<section class="invoice">

    <div class="row">

      @foreach($list_of_keys as $from => $to)

        @foreach ($po_item->jobOrder as $key => $data)

          @if($key >= $from && $key <= $to)

              <div class="col-xs-6" style="margin-bottom:10px;">

                <div style="border:solid 1px; padding:10px;" >
                  <div class="row" style="padding-top:10px;">
                    <div class="col-xs-12">
                      <h2 class="page-header">
                        <img src="{{ asset('images/logo.png') }}" style="width:130px; height:50px; margin-top: -20px"> 
                        <span class="pull-right" style="font-size:20px;">Job Order Form</span>
                      </h2>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xs-12">
                      <table>
                        <tbody>
                          <tr>
                            <td><b>Reference PO No. :</b></td>
                            <td>{{ $po_item->po_no }}</td>
                            <td><b>Lot No :</b></td>
                            <td>{{ $data->lot_no }}</td>
                          </tr>
                          <tr>
                            <td><b>Product Name :</b></td>
                            <td>{{ $data->item_name }}</td>
                            <td><b>Job Order No :</b></td>
                            <td>{{ $data->jo_no }}</td>
                          </tr>
                          <tr>
                            <td><b>Date Required :</b></td>
                            <td>{{ __dataType::date_parse($data->date, 'm/d/Y') }}</td>
                            <td><b>QTY Required :</b></td>
                            <td>{{ number_format($data->amount, 3) .' '. $data->unit }}</td>
                          </tr>
                          <tr>
                            <td><b>Batch Size :</b></td>
                            <td>{{ $data->batch_size }}</td>
                            <td><b>Theoritical Yield :</b></td>
                            <td>{{ $data->theo_yield }}</td>
                          </tr>
                          <tr>
                            <td><b>Pack Size :</b></td>
                            <td>{{ $data->pack_size }}</td>
                            <td></td>
                            <td></td>
                          </tr>
                        </tbody>
                      </table>
                      <p>Prepared By: {{ Auth::user()->fullname }}</p>
                    </div>
                  </div>
                </div>

              </div>

          @endif

        @endforeach

      <footer></footer>
          
      @endforeach

    </div>

  </section> 

</body>
</html>