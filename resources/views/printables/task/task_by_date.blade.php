<!DOCTYPE html>
<html>
<head>
	<title>Schedule of Tasks</title>
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
          <span class="pull-right" style="font-size:30px;">Schedule of Tasks</span>
        </h2>
      </div>
    </div>

    <?php 

      $days = __dynamic::days_between_dates(Request::get('ts_df'), Request::get('ts_dt'));

    ?>

    @foreach ($days as $data_date)

      <div class="row">
        <div class="col-xs-12 table-responsive">
          <h5>{{ __dataType::date_parse($data_date, 'F d, Y - l') }}</h5>

          <table class="table table-bordered" style="font-size:9px;">

            <thead>
              <tr>
                <th style="width:100px;">Activity</th>
                <th style="width:100px;">Personnels</th>
                <th style="width:50px;">QC</th>
                <th style="width:100px;">Remarks</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($task as $data_task)
                <?php
                  $date = __dataType::date_parse($data_date, 'mdY');
                  $task_date = __dataType::date_parse($data_task->date_from, 'mdY');
                ?>
                @if ($date == $task_date)
                  <tr>
                    <td style="padding:4px;">{{ $data_task->name }}</td>
                    <td style="padding:4px;">
                      @foreach ($data_task->taskPersonnel as $data_personnel)
                        {{ optional($data_personnel->personnel)->lastname }},
                      @endforeach
                    </td>
                    <td></td>
                    <td></td>
                  </tr>
                @endif
              @endforeach
            </tbody>

          </table>
        </div>
      </div>

    @endforeach

  </section>

</body>
</html>