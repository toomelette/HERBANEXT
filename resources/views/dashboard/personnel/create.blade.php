@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">New Personnel</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div> 
      </div>
      
      <form method="POST" 
            autocomplete="off" 
            action="{{ route('dashboard.personnel.store') }}" 
            enctype="multipart/form-data">

        <div class="box-body">
          <div class="col-md-12">
                  
            @csrf    

            {!! __form::file(
              '4', 'avatar', 'Upload Avatar', $errors->has('avatar'), $errors->first('avatar'), ''
            ) !!} 

            {!! __form::textbox(
              '4', 'firstname', 'text', 'Firstname *', 'Firstname', old('firstname'), $errors->has('firstname'), $errors->first('firstname'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'middlename', 'text', 'Middlename *', 'Middlename', old('middlename'), $errors->has('middlename'), $errors->first('middlename'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'lastname', 'text', 'Lastname *', 'Lastname', old('lastname'), $errors->has('lastname'), $errors->first('lastname'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'position', 'text', 'Position *', 'Position', old('position'), $errors->has('position'), $errors->first('position'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'contact_no', 'text', 'Contact No.', 'Contact No.', old('contact_no'), $errors->has('contact_no'), $errors->first('contact_no'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'email', 'email', 'Email', 'Email', old('email'), $errors->has('email'), $errors->first('email'), ''
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

    @if(Session::has('PERSONNEL_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('PERSONNEL_CREATE_SUCCESS')) !!}
    @endif

    {!! __js::img_upload('avatar', 'fa', 'URL', '') !!}

  </script>
    
@endsection