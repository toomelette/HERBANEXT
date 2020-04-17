@extends('layouts.admin-master')

@section('content')

<section class="content">
  
  <div class="row">
    <div class="col-md-3">
      <div class="box box-solid">

        <div class="box-header with-border">
          <h4 class="box-title">Tasks</h4>
        </div>

        <div class="box-body">
          <div id="external-events">
            @foreach($unscheduled_tasks as $data)
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




@section('scripts')

<script>

$(function () {

  /* initialize the external events
   -----------------------------------------------------------------*/
  function init_events(ele) {
    ele.each(function () {

      // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
      // it doesn't need to have a start or end
      var eventObject = {
        title: $.trim($(this).text()) // use the element's text as the event title
      }

      // store the Event Object in the DOM element so we can get to it later
      $(this).data('eventObject', eventObject)

      // make the event draggable using jQuery UI
      $(this).draggable({
        zIndex        : 1070,
        revert        : true, // will cause the event to go back to its
        revertDuration: 0  //  original position after the drag
      })

    })
  }

  init_events($('#external-events div.external-event'))

  /* initialize the calendar
   -----------------------------------------------------------------*/
  //Date for the calendar events (dummy data)
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
    //Random default events
    events    : [
      
      @foreach($scheduled_tasks as $data)
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
          url: "/api/task/resize/" + slug,
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
        url: "/api/task/drop/" + slug,
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
          url: "/api/task/eventDrop/" + slug,
          type: "POST",
          data: { 
              start_date : start_date, 
              end_date : end_date, 
              allday: allday 
          },
      });

    },

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