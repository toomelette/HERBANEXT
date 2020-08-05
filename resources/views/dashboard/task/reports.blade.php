@extends('layouts.admin-master')

@section('content')

<section class="content">
       

  {{-- Task Schedule --}}
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title">Task Schedule</h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" 
          id="form_ts" 
          action="{{ route('dashboard.task.reports_output') }}"
          target="_blank">

      <div class="box-body">
        <div class="col-md-12">

          <input type="hidden" id="ft" name="ft" value="ts">

          {!! __form::datepicker(
            '3', 'ts_df',  'Date from *', old('ts_df'), $errors->has('ts_df'), $errors->first('ts_df')
          ) !!}

          {!! __form::datepicker(
            '3', 'ts_dt',  'Date to *', old('ts_dt'), $errors->has('ts_dt'), $errors->first('ts_dt')
          ) !!}

        </div>
      </div>

      <div class="box-footer">
        <button type="submit" class="btn btn-default">
          Print <i class="fa fa-fw fa-print"></i>
        </button>
      </div>

    </form>

  </div>



</section>

@endsection