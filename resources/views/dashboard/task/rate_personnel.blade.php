<?php
  
  function button_color($ov, $bv){

    $string = '';

    if ($ov == $bv) {
      $string = 'bg-yellow';
    }

    return $string;

  }

?>


@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Personnel Ratings</h1>
  </section>

  <section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <code>Please rate the personnel involved in the task based on thier Efficiency.</code>
      </div>
      
      <div class="box-body">

        {{-- Table Grid --}}        
        <div class="box-body no-padding">
          <table class="table table-hover">
            <tr>
              <th>Fullname</th>
              <th>Position</th>
              <th>Rating</th>
            </tr>
            @foreach($task->taskPersonnel as $data) 
              <tr>
                <td id="mid-vert">{{ optional($data->personnel)->fullname }}</td>
                <td id="mid-vert">{{ optional($data->personnel)->position }}</td>
                <td id="mid-vert">
                  @if(in_array('dashboard.task.rate_personnel_post', $global_user_submenus))
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 1) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.task.rate_personnel_post', $data->task_personnel_id) }}"
                       data-val="1">
                          1
                    </a>
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 2) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.task.rate_personnel_post', $data->task_personnel_id) }}"
                       data-val="2">
                          2
                    </a>
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 3) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.task.rate_personnel_post', $data->task_personnel_id) }}"
                       data-val="3">
                          3
                    </a>
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 4) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.task.rate_personnel_post', $data->task_personnel_id) }}"
                       data-val="4">
                          4
                    </a>
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 5) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.task.rate_personnel_post', $data->task_personnel_id) }}"
                       data-val="5">
                          5
                    </a>
                  @endif
                </td>
              </tr>
            @endforeach
          </table>
        </div>
        
      </div>
    </div>

  </section>

  <form id="frm-rp" method="POST" style="display: none;">
    @csrf
    <input id="rating" type="hidden" name="rating">
  </form>

@endsection




@section('scripts')

  <script type="text/javascript">

    $(document).on("click", ".rp", function () {
      if($(this).data("action") == "rp"){
        $("#frm-rp").attr("action", $(this).data("url"));
        $("#rating").val($(this).data("val"));
        $("#frm-rp").submit();
      }
    });

    {{-- UPDATE TOAST --}}
    @if(Session::has('TASK_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('TASK_UPDATE_SUCCESS')) !!}
    @endif

    {{-- DELETE TOAST --}}
    @if(Session::has('TASK_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('TASK_DELETE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection