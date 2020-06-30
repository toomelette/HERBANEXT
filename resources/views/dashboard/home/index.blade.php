<?php
	
	$color_array = [
					"#63b598", "#ce7d78", "#ea9e70", "#a48a9e", "#c6e1e8", "#648177" ,"#0d5ac1" ,
					"#f205e6" ,"#1c0365" ,"#14a9ad" ,"#4ca2f9" ,"#a4e43f" ,"#d298e2" ,"#6119d0",
					"#d2737d" ,"#c0a43c" ,"#f2510e" ,"#651be6" ,"#79806e" ,"#61da5e" ,"#cd2f00" ,
					"#9348af" ,"#01ac53" ,"#c5a4fb" ,"#996635","#b11573" ,"#4bb473" ,"#75d89e" ,
					"#2f3f94" ,"#2f7b99" ,"#da967d" ,"#34891f" ,"#b0d87b" ,"#ca4751" ,"#7e50a8" ,
					"#c4d647" ,"#e0eeb8" ,"#11dec1" ,"#289812" ,"#566ca0" ,"#ffdbe1" ,"#2f1179" ,
					"#935b6d" ,"#916988" ,"#513d98" ,"#aead3a", "#9e6d71", "#4b5bdc", "#0cd36d",
					"#250662", "#cb5bea", "#228916", "#ac3e1b", "#df514a", "#539397", "#880977",
					"#f697c1", "#ba96ce", "#679c9d", "#c6c42c", "#5d2c52", "#48b41b", "#e1cf3b",
					"#5be4f0", "#57c4d8", "#a4d17a", "#225b8", "#be608b", "#96b00c", "#088baf",
					"#f158bf", "#e145ba", "#ee91e3", "#05d371", "#5426e0", "#4834d0", "#802234",
					"#6749e8", "#0971f0", "#8fb413", "#b2b4f0", "#c3c89d", "#c9a941", "#41d158",
					"#fb21a3", "#51aed9", "#5bb32d", "#807fb", "#21538e", "#89d534", "#d36647",
					"#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
					"#79352c", "#521250", "#c79ed2", "#d6dd92", "#e33e52", "#b2be57", "#fa06ec",
					"#1bb699", "#6b2e5f", "#64820f", "#1c271", "#21538e", "#89d534", "#d36647",
					"#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
					"#79352c", "#521250", "#c79ed2", "#d6dd92", "#e33e52", "#b2be57", "#fa06ec",
					"#1bb699", "#6b2e5f", "#64820f", "#1c271", "#9cb64a", "#996c48", "#9ab9b7",
					"#06e052", "#e3a481", "#0eb621", "#fc458e", "#b2db15", "#aa226d", "#792ed8",
					"#73872a", "#520d3a", "#cefcb8", "#a5b3d9", "#7d1d85", "#c4fd57", "#f1ae16",
					"#8fe22a", "#ef6e3c", "#243eeb", "#1dc18", "#dd93fd", "#3f8473", "#e7dbce",
					"#421f79", "#7a3d93", "#635f6d", "#93f2d7", "#9b5c2a", "#15b9ee", "#0f5997",
					"#409188", "#911e20", "#1350ce", "#10e5b1", "#fff4d7", "#cb2582", "#ce00be",
					"#32d5d6", "#17232", "#608572", "#c79bc2", "#00f87c", "#77772a", "#6995ba",
					"#fc6b57", "#f07815", "#8fd883", "#060e27", "#96e591", "#21d52e", "#d00043",
					"#b47162", "#1ec227", "#4f0f6f", "#1d1d58", "#947002", "#bde052", "#e08c56",
					"#28fcfd", "#bb09b", "#36486a", "#d02e29", "#1ae6db", "#3e464c", "#a84a8f",
					"#911e7e", "#3f16d9", "#0f525f", "#ac7c0a", "#b4c086", "#c9d730", "#30cc49",
					"#3d6751", "#fb4c03", "#640fc1", "#62c03e", "#d3493a", "#88aa0b", "#406df9",
					"#615af0", "#4be47", "#2a3434", "#4a543f", "#79bca0", "#a8b8d4", "#00efd4",
					"#7ad236", "#7260d8", "#1deaa7", "#06f43a", "#823c59", "#e3d94c", "#dc1c06",
					"#f53b2a", "#b46238", "#2dfff6", "#a82b89", "#1a8011", "#436a9f", "#1a806a",
					"#4cf09d", "#c188a2", "#67eb4b", "#b308d3", "#fc7e41", "#af3101", "#ff065",
					"#71b1f4", "#a2f8a5", "#e23dd0", "#d3486d", "#00f7f9", "#474893", "#3cec35",
					"#1c65cb", "#5d1d0c", "#2d7d2a", "#ff3420", "#5cdd87", "#a259a4", "#e4ac44",
					"#1bede6", "#8798a4", "#d7790f", "#b2c24f", "#de73c2", "#d70a9c", "#25b67",
					"#88e9b8", "#c2b0e2", "#86e98f", "#ae90e2", "#1a806b", "#436a9e", "#0ec0ff",
					"#f812b3", "#b17fc9", "#8d6c2f", "#d3277a", "#2ca1ae", "#9685eb", "#8a96c6",
					"#dba2e6", "#76fc1b", "#608fa4", "#20f6ba", "#07d7f6", "#dce77a", "#77ecca"
				];

?>

@extends('layouts.admin-master')

@section('content')

<section class="content-header">
    <h1>Dashboard</h1>
</section>

<section class="content">
      
@if (Auth::user()->home_type == 'DWS')
	
	<div class="row">

		<div class="col-lg-3 col-xs-6">
		  <div class="small-box bg-aqua">
		    <div class="inner">
		      <h3>{{ $count_new_po }}</h3>
		      <p>New Purchase Orders</p>
		    </div>
		    <div class="icon">
		      <i class="fa fa-shopping-cart"></i>
		    </div>
		    <a href="{{ route('dashboard.purchase_order.index') }}" class="small-box-footer">
		    	More info <i class="fa fa-arrow-circle-right"></i></a>
		  </div>
		</div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $count_new_tasks }}</h3>
              <p>New Tasks</p>
            </div>
            <div class="icon">
              <i class="fa  fa-tasks"></i>
            </div>
            <a href="{{ route('dashboard.task.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

		<div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $count_new_deliveries }}</h3>
              <p>New Deliveries</p>
            </div>
            <div class="icon">
              <i class="fa fa-truck"></i>
            </div>
            <a href="{{ route('dashboard.delivery.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $count_online_users }}</h3>
              <p>Online Users</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="#" class="small-box-footer">&nbsp;</a>
          </div>
        </div>

	</div>




	<div class="row">

		<div class="col-md-8">
			<div class="box box-success">
				<div class="box-header with-border">
				  <h3 class="box-title">
				  	Most Checked Out Finished Goods this Month
				  </h3>
				</div>

				<div class="box-body">

				  <div class="row">
				    <div class="col-md-8">
				      <div class="chart-responsive">
				        <canvas id="pieChart" height="400"></canvas>
				      </div>
				    </div>

				    <div class="col-md-4">
				      <ul class="chart-legend clearfix">
				      	@foreach ($get_current_month_item_logs->unique('item_id') as $key => $data)
				      		
				      		<?php $count = 0; ?>

				      		@foreach ($get_current_month_item_logs as $data2)
					      		@if ($data->item_id == $data2->item_id)
					      			<?php $count += 1; ?>
					      		@endif
				      		@endforeach

				        	<li>
				        		<i class="fa fa-circle-o" style="color:{{ $color_array[$key] }};"></i> 
				        		{{ optional($data->item)->name }} - {{ $count }}
				        	</li>

				      	@endforeach
				      </ul>
				    </div>
				  </div>

				</div>
			</div>
		</div>


		<div class="col-md-4">
		    <div class="box box-primary">
		        <div class="box-header with-border">
		          <h3 class="box-title">Top 5 Most Efficient Personnel this month</h3>
		        </div>

		        <div class="box-body">
		          <ul class="products-list product-list-in-box">
				      	
				      	<?php
				      		$personnel_array = [];
				      	?>

				      	@foreach ($get_personnel_ratings->unique('personnel_id') as $key => $data)
				      		
				      		<?php 
				      			$partial_rating = 0;
				      			$ave_rating = 0;
				      			$count = 0; 
				      		?>

				      		@foreach ($get_personnel_ratings as $data2)
					      		@if ($data->personnel_id == $data2->personnel_id)
					      			<?php 
					      				$count += 1;
					      				$partial_rating += $data2->rating; 
					      			?>
					      		@endif
				      		@endforeach

				      		<?php

					      		$ave_rating = $partial_rating / $count;

				      			$personnel_array[] = [
				      				'slug' => optional($data->personnel)->slug, 
				      				'avatar_location' => optional($data->personnel)->avatar_location, 
				      				'name' => optional($data->personnel)->fullname, 
				      				'position' => optional($data->personnel)->position,
				      				'rating' => number_format($ave_rating, 2),
				      			];
				      		?>

				      	@endforeach


				      	@foreach (array_slice(collect($personnel_array)->sortBy('rating')->reverse()->toArray(), 0, 5) as $data)

				            <li class="item">
				              <div class="product-img">
				                @if (isset($data['avatar_location']))
				                  <img src="{{ route('dashboard.personnel.view_avatar', $data['slug']) }}" 
				                       class="img-circle" 
				                       alt="Product Image">
				                @else
				                  <img src="{{ asset('images/avatar.jpeg') }}" 
				                       class="img-circle" 
				                       alt="Product Image">
				                @endif
				              </div>
				              <div class="product-info">
				                <a href="#" class="product-title">{{ $data['name'] }}
				                  <span class="badge bg-yellow pull-right">Rating : {{ $data['rating'] }}</span>
				              	</a>
				                <span class="product-description">
			                      {{ $data['position'] }}
			                    </span>
				              </div>
				            </li>
				      		
				      	@endforeach

		          </ul>
		        </div>

		        <div class="box-footer text-center">
		          <a href="{{ route('dashboard.personnel.index') }}" class="uppercase">View All Personnels</a>
		        </div>

		    </div>
		</div>


		<div class="col-md-8">
			
			<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Purchase Orders</h3>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>PO No.</th>
                    <th>Bill to</th>
                    <th>Ship to</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>

              	  @foreach ($get_latest_po as $data)

	                  <tr>
	                    <td id="mid-vert">{{ $data->po_no }}</td>
	                    <td id="mid-vert">
			                <b>{{ $data->bill_to_name }}</b><br>
			                {{ $data->bill_to_company }}<br>
			                {{ $data->bill_to_address }}<br>
			            </td>
	                    <td id="mid-vert">
			                <b>{{ $data->ship_to_name }}</b><br>
			                {{ $data->ship_to_company }}<br>
			                {{ $data->ship_to_address }}<br>
			            </td>
	                    <td id="mid-vert">
	                      {!! $data->displayProcessStatusSpan() !!}
	                    </td>
	                  </tr>

              	  @endforeach

                  </tbody>
                </table>
              </div>
            </div>
            <div class="box-footer clearfix">
              <a href="{{ route('dashboard.purchase_order.index') }}" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div>
          </div>

		</div>



		<div class="col-md-4">
			
			<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Inventory Logs</h3>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
	                  <tr>
	                    <th>Item</th>
	                    <th>Quantity</th>
	                  </tr>
                  </thead>
                  <tbody>

	              	  @foreach ($get_latest_item_logs as $data)
		                <tr>
		                  <td id="mid-vert">{{ $data->item_name }}</td>
		                  <td id="mid-vert">{!! $data->displayAmount() !!}</td>
		                </tr>
	              	  @endforeach

                  </tbody>
                </table>
              </div>
            </div>
            <div class="box-footer clearfix">
              <a href="{{ route('dashboard.item.logs') }}" class="btn btn-sm btn-default btn-flat pull-right">View All Item Logs</a>
            </div>
          </div>

		</div>

	</div>

@endif

	<div class="row">
		<div class="col-md-12">
		    <div class="box box-warning">
		      <div class="box-body no-padding">
		        <div id="calendar"></div>
		      </div>
		    </div>
		</div>
	</div>

</section>

@endsection



@section('scripts')

<script type="text/javascript">
				
	@if (Auth::user()->home_type == 'DWS')
	  // Pie Graph
	  $(function () {

		  'use strict';

		  var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
		  var pieChart       = new Chart(pieChartCanvas);
		  var PieData        = [

		  @foreach ($get_current_month_item_logs->unique('item_id') as $key => $data)
					      		
	  		<?php $count = 0; ?>

	  		@foreach ($get_current_month_item_logs as $data2)
	      		@if ($data->item_id == $data2->item_id)
	      			<?php $count += 1; ?>
	      		@endif
	  		@endforeach

		    {
		      value    : {{ $count }},
		      color    : '{{ $color_array[$key] }}',
		      highlight: '{{ $color_array[$key] }}',
		      label    : '{{ optional($data->item)->name }}'
		    },

		  @endforeach

		  ];

		  var pieOptions     = {

		    segmentShowStroke    : true,
		    segmentStrokeColor   : '#fff',
		    segmentStrokeWidth   : 1,
		    percentageInnerCutout: 50,
		    animationSteps       : 100,
		    animationEasing      : 'easeOutBounce',
		    animateRotate        : true,
		    animateScale         : false,
		    responsive           : true,
		    maintainAspectRatio  : false,
		    legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
		    tooltipTemplate      : '<%=value %> <%=label%>'

		  };

		  pieChart.Doughnut(PieData, pieOptions);

		});

	@endif



    // Calendar
    $(function () {

	  $('#calendar').fullCalendar({

	  	height: 1200,
	  	defaultView: 'agendaWeek',

	    events    : [
	      
	      @foreach($get_scheduled_tasks as $data)
	        {
	          slug            : '{{ $data->slug }}',
	          title           : '{{ $data->name }}',
	          start           : '{{ __dataType::date_parse($data->date_from, "m/d/Y H:i:s") }}',
	          end             : '{{ __dataType::date_parse($data->date_to, "m/d/Y H:i:s") }}',
	          allDay          : {!! $data->is_allday == 1 ? 'true' : 'false' !!},
	          backgroundColor : '{{ $data->color }}',
	          borderColor     : '{{ $data->color }}'
	        },

	      @endforeach

	    ],

	  })

	})

</script>

@endsection