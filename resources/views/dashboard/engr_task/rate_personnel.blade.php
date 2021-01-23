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
      <div class="box-body">
        <code>1 = Late completion with major issues</code><br>
        <code>2 = Late completion with minor issues</code><br>
        <code>3 = On-time with minor issues</code><br>
        <code>4 = On-time with no quality issues</code><br>
        <code>5 = Ahead of time with no quality issues</code>
      </div>
    </div>
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
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
              <th>Remarks</th>
              <th>Rating</th>
            </tr>
            @foreach($engr_task->engrTaskPersonnel as $data) 
              <tr>
                <td id="mid-vert">{{ optional($data->personnel)->fullname }}</td>
                <td id="mid-vert">{{ optional($data->personnel)->position }}</td>
                <td id="mid-vert">{{ $data->remarks }}</td>
                <td id="mid-vert">
                  @if(in_array('dashboard.engr_task.rate_personnel_post', $global_user_submenus))
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 1) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.engr_task.rate_personnel_post', $data->engr_task_personnel_id) }}"
                       data-rating="1"
                       data-remarks="{{ $data->remarks }}">
                          1
                    </a>
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 2) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.engr_task.rate_personnel_post', $data->engr_task_personnel_id) }}"
                       data-rating="2"
                       data-remarks="{{ $data->remarks }}">
                          2
                    </a>
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 3) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.engr_task.rate_personnel_post', $data->engr_task_personnel_id) }}"
                       data-rating="3"
                       data-remarks="{{ $data->remarks }}">
                          3
                    </a>
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 4) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.engr_task.rate_personnel_post', $data->engr_task_personnel_id) }}"
                       data-rating="4"
                       data-remarks="{{ $data->remarks }}">
                          4
                    </a>
                    <a type="button" 
                       class="btn btn-default rp {!! button_color($data->rating, 5) !!}" 
                       data-action="rp" 
                       data-url="{{ route('dashboard.engr_task.rate_personnel_post', $data->engr_task_personnel_id) }}"
                       data-rating="5"
                       data-remarks="{{ $data->remarks }}">
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

@endsection


  

@section('modals')


  {{-- Rate with Description --}}
  <div class="modal fade" id="rate_desc" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">
            Rating
          </h4>
        </div>
        <div class="modal-body" id="rate_desc_body">
          <form method="POST" id="rate_desc_form" autocomplete="off">
            
            @csrf

            <input name="rating" id="rating" type="hidden">

            <div class="row">

              <div class="col-md-12">
                <p style="font-size:15px;">Rating: <span id="rating_text"></span></p>
              </div>

              {!! __form::textbox(
                '12', 'remarks', 'text', 'Remarks', 'Remarks', old('remarks'), $errors->has('remarks'), $errors->first('remarks'), ''
              ) !!}

            </div>

          </div>

          <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Submit <i class="fa fa-fw fa-save"></i></button>
          </form>

        </div>
      </div>
    </div>

  
@endsection




@section('scripts')

  <script type="text/javascript">

    $(document).on("click", ".rp", function () {
      if($(this).data("action") == "rp"){
        $("#rate_desc").modal("show");
        $("#rate_desc_form").attr("action", $(this).data("url"));
        $("#rating_text").text($(this).data("rating"));
        $("#rate_desc_form #rating").val($(this).data("rating"));
        $("#rate_desc_form #remarks").val($(this).data("remarks"));
      }
    });

    {{-- UPDATE TOAST --}}
    @if(Session::has('ENGR_TASK_PERSONNEL_RATING_SUCCESS'))
      {!! __js::toast(Session::get('ENGR_TASK_PERSONNEL_RATING_SUCCESS')) !!}
    @endif

  </script>
    
@endsection