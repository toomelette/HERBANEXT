@extends('layouts.admin-master')

@section('content')

<section class="content">
  
  <div class="row">

    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-body no-padding">
          <div id="calendar"></div>
        </div>
      </div>
    </div>

  </div>

</section>

@endsection




@section('modals')
    
  <div class="modal fade" id="mm_details" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">
            <i class="fa fa-info-circle"></i> &nbsp;Maintenance Details
          </h4>
        </div>

        <div class="modal-body">

          <p style="font-size:17px;">Machine: <span id="machine"></span></p>
          <p style="font-size:17px;">Description: <span id="description"></span></p>
          <p style="font-size:17px;">Date Start: <span id="datetime_from"></span></p>
          <p style="font-size:17px;">Date End: <span id="datetime_to"></span></p>
          <p style="font-size:17px;">Remarks: <span id="remarks"></span></p>

        </div>

        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>

@endsection





@section('scripts')

<script>

$(function () {

  $('#calendar').fullCalendar({

    header    : {
      left  : 'prev,next today',
      center: 'title',
      right : 'month,agendaWeek,agendaDay'
    },
    buttonText: {
      today: 'today',
      month: 'month',
      week : 'week',
      day  : 'day'
    },

    events    : [
      
      @foreach($machine_maintenance_list as $data)

        <?php

            $datetime_from = $data->date_from .' '. $data->time_from;
            $datetime_to = $data->date_to .' '. $data->time_to;

        ?>

        {
          title           : '{{ optional($data->machine)->name }}',
          description           : '{{ $data->description }}',
          remarks           : '{{ $data->remarks }}',
          start           : '{{ __dataType::date_parse($datetime_from, "m/d/Y H:i:s") }}',
          end             : '{{ __dataType::date_parse($datetime_to, "m/d/Y H:i:s") }}',
          allDay          : 'false',
          backgroundColor : '#' + Math.floor(Math.random()*16777215).toString(16),
          borderColor     : '#' + Math.floor(Math.random()*16777215).toString(16)
        },

      @endforeach

    ],



    eventClick: function(info) { 
      
      $( document ).ready(function() {
        
        $("#mm_details").modal("show");

        $("#machine").text('');
        $("#description").text('');
        $("#datetime_from").text('');
        $("#datetime_to").text('');
        $("#remarks").text('');
        
        $("#machine").text(info.title);
        $("#description").text(info.description);
        $("#datetime_from").text(info.start.format('MM/DD/YYYY hh:mm A'));
        $("#datetime_to").text(info.end.format('MM/DD/YYYY hh:mm A'));
        $("#remarks").text(info.remarks);

      });

    }



  })


})

</script>
    
@endsection