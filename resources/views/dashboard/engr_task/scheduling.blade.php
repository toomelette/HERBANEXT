@extends('layouts.admin-master')

@section('content')

<section class="content">
  
  <div class="row">

    <div class="col-md-3">

      <div class="box box-solid">
        <div class="box-header with-border">
          <h4 class="box-title">Job Orders</h4>
        </div>
        <div class="box-body">
          <div id="external-events">
            @foreach($unscheduled_jo as $data)
              <div class="external-event"  
                   data-slug="{{ $data->slug }}" 
                   style="border-color:{{ $data->color }}; background-color:{{ $data->color }};"
              >
                <span style="color:#fff;">{{ $data->name }}</span>
              </div>
            @endforeach  
          </div>
        </div>
      </div>


      <div class="box box-solid">
        <div class="box-header with-border">
          <h4 class="box-title">Daily Activities</h4>
        </div>
        <div class="box-body">
          <div id="external-events">
            @foreach($unscheduled_da as $data)
              <div class="external-event"  
                   data-slug="{{ $data->slug }}" 
                   style="border-color:{{ $data->color }}; background-color:{{ $data->color }};"
              >
                <span style="color:#fff;">{{ $data->name }}</span>
              </div>
            @endforeach  
          </div>
        </div>
      </div>

    </div>


    <div class="col-md-9">
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

          <br>

          <p style="font-size:17px;">Personnels:</p>
          
          <table id="personnels" class="table table-bordered">
            
            <tr>
              <th>Fullname</th>
              <th>Position</th>
            </tr>

          </table>

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

  function init_events(ele) {
    ele.each(function () {

      var eventObject = {
        title: $.trim($(this).text())
      }

      $(this).data('eventObject', eventObject)

      $(this).draggable({
        zIndex        : 1070,
        revert        : true, 
        revertDuration: 0  
      })

    })
  }

  init_events($('#external-events div.external-event'))

  var date = new Date()

  var d    = date.getDate(),
      m    = date.getMonth(),
      y    = date.getFullYear()

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
        
        <?php

          $personnels = [];

          foreach ($data->engrTaskPersonnel as $data_tp) {
            $personnels[] = [
              'fullname' => optional($data_tp->personnel)->fullname,
              'position' => optional($data_tp->personnel)->position,
            ];
          }

        ?>

        {
          slug            : '{{ $data->slug }}',
          title           : '{{ $data->name }}',
          description           : '{{ $data->description }}',
          personnels           : '{!! json_encode($personnels) !!}',
          start           : '{{ __dataType::date_parse($data->date_from, "m/d/Y H:i:s") }}',
          end             : '{{ __dataType::date_parse($data->date_to, "m/d/Y H:i:s") }}',
          allDay          : {!! $data->is_allday == 1 ? 'true' : 'false' !!},
          backgroundColor : '{{ $data->color }}',
          borderColor     : '{{ $data->color }}'
        },

      @endforeach

    ],



    editable  : true,
    eventResize: function(info){

      var slug = info.slug;
      var allday = info.allDay;

      function isEmpty(obj) {
        for(var key in obj) {
            if(obj.hasOwnProperty(key))
                return false;
        }
        return true;
      }

      if(isEmpty(info.end)){
        var start_date = info.start.format('Y-MM-D HH:mm:ss');
        var end_date = info.start.format('Y-MM-D HH:mm:ss');
      }else{
        var start_date = info.start.format('Y-MM-D HH:mm:ss');
        var end_date = info.end.format('Y-MM-D HH:mm:ss');
      }

      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
          url: "/api/engr_task/resize/" + slug,
          type: "POST",
          data: { 
                start_date : start_date, 
                end_date : end_date, 
                allday : allday 
          },
      });

    },



    droppable : true,
    displayEventEnd : true,
    drop      : function (date, allDay) {

      var originalEventObject = $(this).data('eventObject')
      var copiedEventObject = $.extend({}, originalEventObject)

      copiedEventObject.start           = date
      copiedEventObject.allDay          = allDay
      copiedEventObject.backgroundColor = $(this).css('background-color')
      copiedEventObject.borderColor     = $(this).css('border-color')

      var slug = $(this).data('slug')
      var start_date = date.format('Y-MM-D HH:mm:ss')

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: "/api/engr_task/drop/" + slug,
        type: "POST",
        data: { date : start_date },
      });

      $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)
      $(this).remove()

      location.reload();

    },



    eventDrop : function (event) { 

      var slug = event.slug;
      var allday = event.allDay;

      function isEmpty(obj) {
        for(var key in obj) {
            if(obj.hasOwnProperty(key))
                return false;
        }
        return true;
      }

      if (isEmpty(event.end)) {
        var start_date = event.start.format('Y-MM-D HH:mm:ss');
        var end_date = event.start.format('Y-MM-D HH:mm:ss');
      }else {
        var start_date = event.start.format('Y-MM-D HH:mm:ss');
        var end_date = event.end.format('Y-MM-D HH:mm:ss');
      }

      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
          url: "/api/engr_task/eventDrop/" + slug,
          type: "POST",
          data: { 
              start_date : start_date, 
              end_date : end_date, 
              allday: allday 
          },
      });

    },



    eventClick: function(info) { 
      
      $( document ).ready(function() {
        
        $("#task_details").modal("show");

        $("#personnels tr td").remove();

        $("#title").text('');
        $("#description").text('');
        $("#datetime_from").text('');
        $("#datetime_to").text('');

        $("#title").text(info.title);
        $("#description").text(info.description);
        $("#datetime_from").text(info.start.format('MM/DD/YYYY hh:mm A'));

        if(info.allDay == false){
          $("#datetime_to").text(info.end.format('MM/DD/YYYY hh:mm A'));
        }

        $.each(JSON.parse(info.personnels), function (index, data) {
            var html = '';
            html += "<tr>";
            html += "<td>" + data.fullname + "</td>";
            html += "<td>" + data.position + "</td>";
            html += "</tr>";
            $("#personnels").append(html);
        });

      });

    }



  })

  var currColor = '#3c8dbc'
  var colorChooser = $('#color-chooser-btn')

  $('#color-chooser > li > a').click(function (e) {
    e.preventDefault()
    currColor = $(this).css('color')
    $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
  })

  $('#add-new-event').click(function (e) {

    e.preventDefault()
    
    var val = $('#new-event').val()

    if (val.length == 0) {
      return
    }

    var event = $('<div />')

    event.css({
      'background-color': currColor,
      'border-color'    : currColor,
      'color'           : '#fff'
    }).addClass('external-event')

    event.html(val)
    
    $('#external-events').prepend(event)

    init_events(event)

    $('#new-event').val('')

  })
})

</script>
    
@endsection