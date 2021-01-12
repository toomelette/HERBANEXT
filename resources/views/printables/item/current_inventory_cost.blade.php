<?php


    function sortedList($collection){

        $array = [];

        foreach ($collection as $data) {

            $cost = 0;

            if (isset($data->current_balance) && isset($data->price)){
                $cost = $data->current_balance * $data->price;
            }

            $array[] = array(

                'product_code' => $data->product_code,
                'name' => $data->name,
                'current_balance' => number_format($data->current_balance, 3),
                'price' => number_format($data->price, 2) .'/'. $data->unit,
                'cost' => $cost,

            );

        }

        usort($array, function($a, $b) {
            return $b['cost'] <=> $a['cost'];
        });

        return $array;


    }


?>

<!DOCTYPE html>
<html>
<head>
	<title>Current Inventory COST</title>
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
        <span style="font-size:20px;">CURRENT INVENTORY COST</span><br>
        <p style="font-size:15px;">{{ $item_cat_name }}</p>        
    </div>

    

    <div class="row" style="font-size:9px;">
        <div class="col-xs-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width:100px;">Product Code</th>
                        <th style="width:100px;">Product Name</th>
                        <th style="width:100px;">Current Balance</th>
                        <th style="width:100px;">Price</th>
                        <th style="width:50px;">Current Inventory Cost</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        $total_cost = 0;
                        $list = sortedList($items);
                    ?>

                    @foreach ($list as $data)

                        <?php
                            $total_cost += $data['cost'];
                        ?>

                        <tr>
                            <td style="padding:4px;">{{ $data['product_code'] }}</td>
                            <td style="padding:4px;">{{ $data['name'] }}</td>
                            <td style="padding:4px;">{{ $data['current_balance'] }}</td>
                            <td style="padding:4px;">Php {{ $data['price'] }}</td>
                            <td style="padding:4px;">Php {{ number_format($data['cost'], 3) }}</td>
                        </tr>

                    @endforeach

                    {{-- TOTAL --}}

                    <tr>
                        <td><b>TOTAL COST</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Php {{ number_format($total_cost, 3) }}</td>
                    </tr>

                </tbody>    
            </table>
        </div>
    </div>

  </section>

</body>
</html>