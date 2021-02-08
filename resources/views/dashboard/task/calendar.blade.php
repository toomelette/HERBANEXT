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

function decodeHTMLEntities(str) {
  if(str && typeof str === 'string') {
    str = str.replace(/&[#A-Za-z0-9]+;/gi, '');
  }
  return str;
}


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
      
      @foreach($scheduled_tasks as $data)
        
        <?php

          $personnels = [];

          foreach ($data->taskPersonnel as $data_tp) {
            $personnels[] = [
              'fullname' => optional($data_tp->personnel)->fullname,
              'position' => optional($data_tp->personnel)->position,
            ];
          }

        ?>

        {
          slug            : '{{ $data->slug }}',
          title           : decodeHTMLEntities('{{ $data->name }}'),
          description     : decodeHTMLEntities('{{ $data->description }}'),
          personnels      : '{!! json_encode($personnels) !!}',
          dateTo          : '{{ __dataType::date_parse($data->date_to, "m/d/Y h:i A") }}',
          start           : '{{ __dataType::date_parse($data->date_from, "m/d/Y H:i:s") }}',
          end             : '{{ __dataType::date_parse($data->date_to, "m/d/Y H:i:s") }}',
          allDay          : {!! $data->is_allday == 1 ? 'true' : 'false' !!},
          backgroundColor : '#' + Math.floor(Math.random()*16777215).toString(16),
          borderColor     : '#' + Math.floor(Math.random()*16777215).toString(16),
          forceEventDuration : true,
        },

      @endforeach

    ],



    eventClick: function(info) { 
      
      $( document ).ready(function() {
        
        $("#task_details").modal("show");

        $("#personnels tr td").remove();

        $("#title").text('');
        $("#description").text('');
        $("#datetime_from").text('');
        $("#datetime_to").text('');
        
        $("#title").text(info.title);
        $("#description").text(decodeHTMLEntities(info.description));
        $("#datetime_from").text(info.start.format('MM/DD/YYYY hh:mm A'));
        $("#datetime_to").text(info.dateTo);

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


})

</script>
    
@endsection