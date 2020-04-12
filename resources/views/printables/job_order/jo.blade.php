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
      <div style="border:solid 1px; padding:10px;" >
        <div class="row" style="padding-top:10px;">
          <div class="col-xs-12">
            <h2 class="page-header">
              <img src="{{ asset('images/logo.png') }}" style="width:200px; height:70px; margin-top: -20px"> 
              <span class="pull-right" style="font-size:30px;">Job Order Form</span>
            </h2>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-6">
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
                    <td>{{ $data->batch_size }}</td>
                  </tr>
                  <tr>
                    <td>Pack Size :</td>
                    <td>{{ $data->pack_size }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="table-responsive">
              <table class="table table-striped">
                <tbody>
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
                    <td>{{ $data->theo_yield }}</td>
                  </tr>
              </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    @endforeach

  </section>

</body>
</html>