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

    @foreach ($po_item->jobOrder as $key => $data)

      <div class="row" style="padding-top:10px;">
        <div class="col-xs-12">
          <h2 class="page-header">
            <img src="{{ asset('images/logo.png') }}" style="width:200px; height:70px; margin-top: -20px"> 
            <span class="pull-right" style="font-size:30px;">Job Order Form</span>
          </h2>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class="table-responsive">
            <table class="table table-striped">
              <tbody>
                  <tr>
                    <td>Reference PO No. :</td>
                    <td>{{ $po_item->po_no }}</td>
                  </tr>
                  <tr>
                    <td>Product Name :</td>
                    <td>{{ $data->item_name }}</td>
                  </tr>
                  <tr>
                    <td>Date Required :</td>
                    <td>{{ __dataType::date_parse($data->date, 'm/d/Y') }}</td>
                  </tr>
                  <tr>
                    <td>Batch Size :</td>
                    <td>{{ number_format($data->batch_size, 3) .' '. $data->batch_size_unit }}</td>
                  </tr>
                  <tr>
                    <td>Pack Size :</td>
                    <td>{{ number_format($data->pack_size, 3) .' '. $data->pack_size_unit .' / '. $data->pack_size_pkging }}</td>
                  </tr>
                  <tr>
                    <td>Lot No :</td>
                    <td>{{ $data->lot_no }}</td>
                  </tr>
                  <tr>
                    <td>Job Order No :</td>
                    <td>{{ $data->jo_no }}</td>
                  </tr>
                  <tr>
                    <td>QTY Required :</td>
                    <td>{{ number_format($data->amount, 3) .' '. $data->unit }}</td>
                  </tr>
                  <tr>
                    <td>Theoritical Yield :</td>
                    <td>{{ number_format($data->theo_yield, 3) .' '. $data->theo_yield_pkging }}</td>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    @endforeach


    <div class="row no-print">
      <div class="col-xs-12">
        <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
      </div>
    </div>

  </section>

</body>
</html>