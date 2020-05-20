@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title" style="padding-top: 5px;">Edit Supplier</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
            &nbsp;
            {!! __html::back_button(['dashboard.supplier.index']) !!}
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.supplier.update', $supplier->slug) }}">

        <div class="box-body">
          <div class="col-md-12">

            <input name="_method" value="PUT" type="hidden">

            @csrf    

            {!! __form::textbox(
              '4', 'name', 'text', 'Supplier Name *', 'Supplier Name', old('name') ? old('name') : $supplier->name, $errors->has('name'), $errors->first('name'), ''
            ) !!} 

            {!! __form::textbox(
              '4', 'description', 'text', 'Description', 'Description', old('description') ? old('description') : $supplier->description, $errors->has('description'), $errors->first('description'), ''
            ) !!} 

            {!! __form::textbox(
              '4', 'address', 'text', 'Address', 'Address', old('address') ? old('address') : $supplier->address, $errors->has('address'), $errors->first('address'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
              '4', 'contact_email', 'text', 'Contact No. / Email', 'Contact No. / Email', old('contact_email') ? old('contact_email') : $supplier->contact_email, $errors->has('contact_email'), $errors->first('contact_email'), ''
            ) !!} 

            {!! __form::textbox(
              '4', 'contact_person', 'text', 'Contact Person', 'Contact Person', old('contact_person') ? old('contact_person') : $supplier->contact_person, $errors->has('contact_person'), $errors->first('contact_person'), ''
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