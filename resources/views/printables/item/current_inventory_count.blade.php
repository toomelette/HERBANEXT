<!DOCTYPE html>
<html>
<head>
	<title>Current Inventory Count</title>
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
          <p class="pull-right" style="font-size:30px;">Inventory Report</p>
        </h2>
      </div>
    </div>

    <div class="row" style="text-align:center;">
        <span style="font-size:20px;">CURRENT INVENTORY COUNT</span><br>
        <p style="font-size:15px;">{{ $item_cat_name }}</p>        
    </div>

    

    <div class="row" style="font-size:9px;">
        <div class="col-xs-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width:100px;">Product Code</th>
                        <th style="width:100px;">Product Name</th>
                        <th style="width:50px;">Current Inventory Count</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        $total_pcs = 0;
                        $total_weight = 0;
                        $total_volume = 0;
                    ?>

                    @foreach ($items as $data)

                        <?php

                            if($data->unit_type_id == 'IU1001'){
                                $total_pcs += $data->current_balance;
                            }elseif($data->unit_type_id == 'IU1002'){
                                $balance_weight = Conversion::convert($data->current_balance, $data->unit)->to('KILOGRAM')->format(3,'.','');
                                $total_weight += $balance_weight;
                            }elseif($data->unit_type_id == 'IU1003'){
                                $balance_volume = Conversion::convert($data->current_balance, $data->unit)->to('LITRE')->format(3,'.','');
                                $total_volume += $balance_volume;
                            }

                        ?>

                        <tr>
                            <td style="padding:4px;">{{ $data->product_code }}</td>
                            <td style="padding:4px;">{{ $data->name }}</td>
                            <td style="padding:4px;">{{ $data->current_balance }} {{ $data->unit }}</td>
                        </tr>

                    @endforeach

                    {{-- TOTAL --}}

                    <tr>
                        <td><b>TOTAL QUANTITY</b></td>
                        <td>{{ number_format($total_pcs, 3) }} PCS</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><b>TOTAL WEIGHT</b></td>
                        <td>{{ number_format($total_weight, 3) }} KILOGRAMS</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><b>TOTAL VOLUME</b></td>
                        <td>{{ number_format($total_volume, 3) }} LITERS</td>
                        <td></td>
                    </tr>

                </tbody>    
            </table>
        </div>
    </div>

  </section>

</body>
</html>