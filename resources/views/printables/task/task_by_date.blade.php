<!DOCTYPE html>
<html>
<head>
	<title>Schedule of Tasks</title>
	<link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/skins/_all-skins.min.css') }}">
</head>
<body {{-- onload="window.print();" onafterprint="window.close()" --}}>

	<section class="invoice">

    <div class="row" style="padding-top:10px;">
      <div class="col-xs-12">
        <h2 class="page-header">
          <img src="{{ asset('images/logo.png') }}" style="width:200px; height:70px; margin-top: -20px"> 
          <span class="pull-right" style="font-size:30px;">Schedule of Tasks</span>
        </h2>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 table-responsive">

        <table class="table table-bordered">

          <thead>

            <tr>
              <th>Day</th>
            </tr>

          </thead>

          <tbody>

            <?php 
              $days = __dynamic::days_between_dates(Request::get('ts_df'), Request::get('ts_dt'));
              //echo dd($days);
            ?>

            @foreach ($days as $data_date)
              
              <tr>
                <td>{{ __dataType::date_parse($data_date, 'F d, Y l') }}</td>
              </tr>

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

  </section>

</body>
</html>