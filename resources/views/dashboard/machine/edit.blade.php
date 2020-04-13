@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title" style="padding-top: 5px;">Edit Machine</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
            &nbsp;
            {!! __html::back_button(['dashboard.machine.index']) !!}
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.machine.update', $machine->slug) }}">

        <div class="box-body">
          <div class="col-md-12">

            <input name="_method" value="PUT" type="hidden">

            @csrf    

            {!! __form::textbox(
              '4', 'name', 'text', 'Name *', 'Name', old('name') ? old('name') : $machine->name, $errors->has('name'), $errors->first('name'), ''
            ) !!} 

            {!! __form::textbox(
              '8', 'description', 'text', 'Description', 'Description', old('description') ? old('description') : $machine->description, $errors->has('description'), $errors->first('description'), ''
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