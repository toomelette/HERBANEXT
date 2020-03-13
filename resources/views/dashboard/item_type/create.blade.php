@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">New Item Type</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.item_type.store') }}">

        <div class="box-body">
          <div class="col-md-12">
                  
            @csrf    

            {!! __form::textbox(
              '4', 'name', 'text', 'Name *', 'Name', old('name'), $errors->has('name'), $errors->first('name'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'percent', 'numeric', 'Percent (%) *', 'Percent (%)', old('percent'), $errors->has('percent'), $errors->first('percent'), ''
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

    @if(Session::has('ITEM_TYPE_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('ITEM_TYPE_CREATE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection 