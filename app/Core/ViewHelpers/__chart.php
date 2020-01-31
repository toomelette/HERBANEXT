<?php

namespace App\Core\ViewHelpers;

  

class __chart{



	// Flot Donut
    public static function div_flot_donut($class, $id, $title){

       return '<div class="col-md-'. $class .'">
		          <div class="box box-primary">
		            <div class="box-header with-border">
		              <i class="fa fa-bar-chart-o"></i>

		              <h3 class="box-title">'. $title .'</h3>
		            </div>
		            <div class="box-body">
		              <div id="'. $id .'" style="height: 300px;"></div>
		            </div>
		          </div>
		        </div>';

    }



    public static function js_flot_donut($id, $string){

       return 'var donutData = '. $string .'
			    $.plot("#'. $id .'", donutData, {
			      series: {
			        pie: {
			          show       : true,
			          radius     : 1,
			          innerRadius: 0.5,
			          label      : {
			            show     : true,
			            radius   : 2 / 3,
			            formatter: labelFormatter,
			            threshold: 0.1
			          }

			        }
			      },
			      legend: {
			        show: false
			      }
			    });';

    }






	// Flot Bar
    public static function div_flot_bar($class, $id, $title){

       return '<div class="col-md-'. $class .'">
		          <div class="box box-primary">
		            <div class="box-header with-border">
		              <i class="fa fa-bar-chart-o"></i>

		              <h3 class="box-title">'. $title .'</h3>
		            </div>
		            <div class="box-body">
		              <div id="'. $id .'" style="height: 300px;"></div>
		            </div>
		          </div>
		        </div>';

    }



    public static function js_flot_bar($id, $string){

       return 'var bar_data = {
			      data : ['. $string .'],
			      color: "#3c8dbc"
			    }
			    $.plot("#'. $id .'", [bar_data], {
			      grid  : {
			        borderWidth: 1,
			        borderColor: "#f3f3f3",
			        tickColor  : "#f3f3f3"
			      },
			      series: {
			        bars: {
			          show    : true,
			          barWidth: 0.5,
			          align   : "center"
			        }
			      },
			      xaxis : {
			        mode      : "categories",
			        tickLength: 0
			      }
			    });';

    }







}