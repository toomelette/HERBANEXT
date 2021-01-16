@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">New Machine</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.machine.store') }}">

        <div class="box-body">
          <div class="col-md-12">
                  
            @csrf    

            {!! __form::textbox(
              '6', 'name', 'text', 'Name *', 'Name', old('name'), $errors->has('name'), $errors->first('name'), ''
            ) !!}

            {!! __form::textbox(
              '6', 'code', 'text', 'Code', 'Code', old('code'), $errors->has('code'), $errors->first('code'), ''
            ) !!}

            {!! __form::textbox(
              '6', 'description', 'text', 'Description', 'Description', old('description'), $errors->has('description'), $errors->first('description'), ''
            ) !!}

            {!! __form::textbox(
              '6', 'location', 'text', 'Location', 'Location', old('location'), $errors->has('location'), $errors->first('location'), ''
            ) !!}

          </div>
        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-default">Save <i class="fa fa-fw fa-save"></i></button>
        </div>

      </form>

    </div>

</section>

@endsection




@section('scripts')

  <script type="text/javascript">

    @if(Session::has('MACHINE_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('MACHINE_CREATE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection