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
    
  <div class="modal fade" id="task_details" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">
            <i class="fa fa-info-circle"></i> &nbsp;Task Details
          </h4>
        </div>

        <div class="modal-body">

          <p style="font-size:17px;">Title: <span id="title"></span></p>
          <p style="font-size:17px;">Description: <span id="description"></span></p>
          <p style="font-size:17px;">Date Start: <span id="datetime_from"></span></p>
          <p style="font-size:17px;">Date End: <span id="datetime_to"></span></p>

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
      
      @foreach($scheduled_engr_tasks as $data)
        {
          slug            : '{{ $data->slug }}',
          title           : '{{ $data->name }}',
          description           : '{{ $data->description }}',
          start           : '{{ __dataType::date_parse($data->date_from, "m/d/Y H:i:s") }}',
          end             : '{{ __dataType::date_parse($data->date_to, "m/d/Y H:i:s") }}',
          allDay          : {!! $data->is_allday == 1 ? 'true' : 'false' !!},
          backgroundColor : '{{ $data->color }}',
          borderColor     : '{{ $data->color }}'
        },

      @endforeach

    ],



    eventClick: function(info) { 
      
      $( document ).ready(function() {
        $("#task_details").modal("show");
        $("#title").text(info.title);
        $("#description").text(info.description);
        $("#datetime_from").text(info.start.format('MM/DD/YYYY hh:mm A'));
        $("#datetime_to").text(info.end.format('MM/DD/YYYY hh:mm A'));
      });

    }



  })


})

</script>
    
@endsection