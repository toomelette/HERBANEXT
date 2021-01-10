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
        <span style="font-size:25px;">CURRENT INVENTORY COST</span><br>
        <p style="font-size:20px;">{{ $item_cat_name }}</p>        
    </div>

    

    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width:100px;">Product Code</th>
                        <th style="width:100px;">Product Name</th>
                        <th style="width:100px;">Current <br>Balance</th>
                        <th style="width:100px;">Price</th>
                        <th style="width:50px;">Current <br>Inventory Cost</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        $total_cost = 0;
                    ?>

                    @foreach ($items as $data)

                        <?php
                        
                            $cost = 0;

                            if(isset($data->current_balance) && isset($data->price)){
                                $cost = $data->current_balance * $data->price;
                                $total_cost += $cost;
                            }
                        ?>

                        <tr>
                            <td>{{ $data->product_code }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ number_format($data->current_balance, 3) }}</td>
                            <td>Php {{ number_format($data->price, 2) }} / {{ $data->unit }}</td>
                            <td>Php {{ number_format($cost, 3) }}</td>
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