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
        <code>Please rate the personnel involved in the engr_task based on their Efficiency.</code>
        <div class="pull-right">
          <a href="{{ route('dashboard.engr_task.index') }}" class="btn btn-sm btn-default">
            <i class="fa fa-fw fa-arrow-left"></i>Back
          </a>
        </div> 
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
            @foreach($engr_task->engrTaskPersonnel as $data) 
              <tr>
                <td id="mid-vert">{{ optional($data->personnel)->fullname }}</td>
                <td id="mid-vert">{{ optional($data->personnel)->position }}</td>
                <td id="mid-vert">
                  @if(in_array('dashboard.engr_task.rate_personnel_post', $global_user_submenus))
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 1) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.engr_task.rate_personnel_post', $data->engr_task_personnel_id) }}"
                       data-val="1">
                          1
                    </a>
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 2) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.engr_task.rate_personnel_post', $data->engr_task_personnel_id) }}"
                       data-val="2">
                          2
                    </a>
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 3) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.engr_task.rate_personnel_post', $data->engr_task_personnel_id) }}"
                       data-val="3">
                          3
                    </a>
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 4) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.engr_task.rate_personnel_post', $data->engr_task_personnel_id) }}"
                       data-val="4">
                          4
                    </a>
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 5) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.engr_task.rate_personnel_post', $data->engr_task_personnel_id) }}"
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
    @if(Session::has('engr_TASK_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('engr_TASK_UPDATE_SUCCESS')) !!}
    @endif

    {{-- DELETE TOAST --}}
    @if(Session::has('engr_TASK_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('engr_TASK_DELETE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection